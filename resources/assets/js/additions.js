$(document).ready(function () {
    Waves.attach('.btn-primary', ['waves-light']);
    Waves.attach('.btn-secondary', ['waves-light']);
    Waves.attach('.btn-success', ['waves-light']);
    Waves.attach('.btn-danger', ['waves-light']);
    Waves.attach('.btn-warning', ['waves-light']);
    Waves.attach('.btn-info', ['waves-light']);
    Waves.attach('.btn-light', ['waves-dark']);
    Waves.attach('.btn-dark', ['waves-light']);

    Waves.attach('.dropdown-item.active', ['waves-light']);
    Waves.attach('.dropdown-item', ['waves-dark']);
    Waves.attach('.nav-item.active > .nav-link', ['waves-light']);
    Waves.attach('.nav-item > .nav-link', ['waves-light']);
    Waves.attach('a.card-header', ['waves-light']);

    Waves.init();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('[data-type="submit"]').click(function () {
        $(this).closest('form').submit();
    });

    $('[data-type="scroll-top"]').each(function () {
        $(this).click(function () {
            $('html, body').animate({ scrollTop: 0 }, 600);
        })
    });

    $('[data-scroll-to-element]').each(function () {
        let $this = $(this);

        $this.click(function () {
            let scrollElement = $($this.attr('data-scroll-to-element'));

            $('html, body').animate({scrollTop: scrollElement.offset().top}, 'slow');
        });
    });

    $('[data-confirm]').click(function () {
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

        $this.click(function (event) {
            event.preventDefault();

            $($this.attr('data-click')).submit();
        });
    });

    $('[data-mark-as-read]').each(function () {
        let $this = $(this);

        $this.click(function (event) {
           event.preventDefault();

            $.ajax({
                method: 'PUT',
                url: $this.attr('data-mark-as-read'),
            }).done(function () {
                $($this.attr('data-target')).addClass('low-opacity');

                $this.remove();
            }).fail(function () {
                console.error('Could not mark the feed item as read.');
            });
        });
    });

    $('[data-toggle="tooltip"]').tooltip();
});