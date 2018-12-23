import baseTranslator from "./baseTranslator";

$(document).ready(function () {
    window.trans = baseTranslator(window.TRANSLATIONS);

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

    $('[data-type="submit"]').on('click', function (e) {
        e.preventDefault();

        const $this = $(this);
        const $formSelector = $this.attr('data-form');
        const $formElement = _.isEmpty($formSelector) ? $this.closest('form') : $($formSelector);

        console.log($formSelector);
        console.log($formElement);

        $formElement.submit();

        console.log($('#vote_up_24887'));
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

    $(document).on('click', '[data-vote]', function (event) {
        event.preventDefault();

        const $this = $(this);

        $.ajax({
            method: 'PUT',
            url: $this.attr('data-vote'),
        }).done(function (response) {
            const attrClasses = {
                NONE: 'btn-outline-dark',
                UP: 'btn-success',
                DOWN: 'btn-danger',
            };

            $this.attr('class', `btn btn-xs ${_.get(attrClasses, response.vote_status)}`);

            $($this.attr('data-other')).attr('class', 'btn btn-xs btn-outline-dark');
        }).fail(function () {
            console.error('Could vote for the given item.');
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

    $('[data-provide="minicolors"]').each(function () {
        let $this = $(this);

        $this.minicolors({
            control: $this.attr('data-control') || 'hue',
            defaultValue: $this.attr('data-default-value') || '',
            format: $this.attr('data-format') || 'hex',
            keywords: $this.attr('data-keywords') || '',
            inline: $this.attr('data-inline') === 'true',
            letterCase: $this.attr('data-letter-case') || 'lowercase',
            opacity: $this.attr('data-opacity'),
            position: $this.attr('data-position') || 'bottom left',
            swatches: $this.attr('data-swatches') ? $this.attr('data-swatches').split('|') : [],
            theme: 'bootstrap'
        });
    });

    $('[data-provide="multiselect"]').multiselect({
        enableClickableOptGroups: true,
        includeSelectAllOption: true,
        numberDisplayed: 1,
        maxHeight: 350,
        buttonClass: 'btn btn-outline-dark',
        nonSelectedText: trans('multiselect.nonSelectedText'),
        nSelectedText: trans('multiselect.nSelectedText'),
        allSelectedText: trans('multiselect.allSelectedText'),
        selectAllText: trans('multiselect.selectAllText'),
        buttonContainer: '<div class="dropdown" />',
        templates: {
            li: '<li class="dropdown-item"><a href="javascript:void(0);"><label></label></a></li>',
            liGroup: '<li class="dropdown-item"><a href="javascript:void(0);"><label></label></a></li>',
            divider: '<li class="dropdown-divider"></li>',
        },
    });

    $('[data-provide="datepicker"]').each(function () {
        const $this = $(this);
        const date = $this.find('input').val();
        const dateFormat = trans('datepicker.formats.date');

        const baseConfig = {
            locale: $('html').attr('lang'),
            format: dateFormat,
            useCurrent: true,
            calendarWeeks: true,
            allowInputToggle: true,
        };

        const config = date ? _.merge(baseConfig, {
            defaultDate: moment(date, dateFormat)
        }) : baseConfig;

        $this.datetimepicker(config);
    });
});