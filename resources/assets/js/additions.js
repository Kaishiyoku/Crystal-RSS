$(document).ready(function () {
    Waves.attach('.btn-primary', ['waves-light']);
    Waves.attach('.btn-secondary', ['waves-light']);
    Waves.attach('.btn-success', ['waves-light']);
    Waves.attach('.btn-danger', ['waves-light']);
    Waves.attach('.btn-warning', ['waves-light']);
    Waves.attach('.btn-info', ['waves-light']);
    Waves.attach('.btn-light', ['waves-dark']);
    Waves.attach('.btn-dark', ['waves-light']);

    Waves.attach('.btn-outline-primary', ['waves-light']);
    Waves.attach('.btn-outline-secondary', ['waves-light']);
    Waves.attach('.btn-outline-success', ['waves-light']);
    Waves.attach('.btn-outline-danger', ['waves-light']);
    Waves.attach('.btn-outline-warning', ['waves-light']);
    Waves.attach('.btn-outline-info', ['waves-light']);
    Waves.attach('.btn-outline-light', ['waves-dark']);
    Waves.attach('.btn-outline-dark', ['waves-light']);

    Waves.attach('.dropdown-item.active', ['waves-light']);
    Waves.attach('.dropdown-item', ['waves-dark']);
    Waves.attach('.nav-item.active > .nav-link', ['waves-light']);
    Waves.attach('.nav-item > .nav-link', ['waves-light']);
    Waves.attach('a.card-header', ['waves-light']);

    Waves.attach('a.page-link', ['waves-dark']);

    Waves.init();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('[data-type="submit"]').on('click', function () {
        $(this).closest('form').submit();
    });

    $('[data-type="scroll-top"]').each(function () {
        $(this).on('click', function () {
            $('html, body').animate({ scrollTop: 0 }, 600);
        })
    });

    $('[data-scroll-to-element]').each(function () {
        let $this = $(this);

        $this.on('click', function () {
            let scrollElement = $($this.attr('data-scroll-to-element'));

            $('html, body').animate({scrollTop: scrollElement.offset().top}, 'slow');
        });
    });

    $('[data-confirm]').on('click', function () {
        let confirmationText = $(this).attr('data-confirm');

        if (_.isEmpty(confirmationText) || confirmationText == 1) {
            confirmationText = CONFIG.confirm.defaultText;
        }

        if (!confirm(confirmationText)) {
            return false;
        }
    });

    $('[data-click]').each(function () {
        let $this = $(this);

        $this.on('click', function (event) {
            event.preventDefault();

            $($this.attr('data-click')).submit();
        });
    });

    $(document).on('click', '[data-toggle-status]', function (event) {
        event.preventDefault();

        let $this = $(this);

        $.ajax({
            method: 'PUT',
            url: $this.attr('data-toggle-status'),
        }).done(function (response) {
            if (response.isRead) {
                $this.html('<i class="fa fa-eye-slash" aria-hidden="true"></i>');
                $($this.attr('data-target')).addClass('low-opacity');
            } else {
                $this.html('<i class="fa fa-eye" aria-hidden="true"></i>');
                $($this.attr('data-target')).removeClass('low-opacity');
            }
        }).fail(function () {
            console.error('Could not mark the feed item as read.');
        });
    });

    $('[data-toggle="tooltip"]').tooltip();

    $('[data-provide="tablesorter"]').each(function () {
        $(this).tablesorter({
            theme: 'bootstrap-custom',
            widgets: ['columns'],
            widgetOptions: {
                columns: ['primary', 'secondary', 'tertiary']
            }
        });
    });

    $('[data-load-more]').each(function () {
        let $this = $(this);
        let button = $($this.attr('data-button'));

        button.on('click', function () {
            event.preventDefault();

            let url = $this.attr('data-load-more');

            $.ajax({
                method: 'GET',
                url: url,
            }).done(function (response) {
                let nextUrl = response.nextUrl;

                $this.append(response.content);
                $this.attr('data-load-more', nextUrl);

                if (!response.hasAnotherPage) {
                    button.remove();
                }
            }).fail(function () {
                console.error('Could not fetch more unread feed items.');
            });
        });
    });
});