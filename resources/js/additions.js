import Voter from "./components/Voter";
import baseTranslator from "./baseTranslator";
import ReactDOM from "react-dom";
import React from "react";
import * as Logger from 'js-simple-logger';
import Favoriter from './components/Favoriter';
import FeedDiscoverer from './components/FeedDiscoverer';
import tippy from 'tippy.js';

Logger.setMinimumLogLevel(Logger.getLogLevels().WARN);

$(document).ready(function () {
    window.trans = baseTranslator(window.TRANSLATIONS);

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

        $formElement.submit();
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

    $('[data-provide="minicolors"]').each(function () {
        const $this = $(this);

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
            theme: 'bootstrap',
        });
    });

    $('[data-provide="voter"]').each(function () {
        const dataVoteUpUrl = $(this).attr('data-vote-up-url');
        const dataVoteDownUrl = $(this).attr('data-vote-down-url');
        const dataToken = $('meta[name="csrf-token"]').attr('content');
        const dataVoteStatus = $(this).attr('data-vote-status');

        ReactDOM.render(<Voter voteUpUrl={dataVoteUpUrl} voteDownUrl={dataVoteDownUrl} token={dataToken} voteStatus={dataVoteStatus}/>, $(this)[0]);
    });

    $('[data-provide="favoriter"]').each(function () {
        const dataUrl = $(this).attr('data-url');
        const dataToken = $('meta[name="csrf-token"]').attr('content');
        const dataFavoritedAt =$(this).attr('data-favorited-at');

        ReactDOM.render(<Favoriter url={dataUrl} token={dataToken} favoritedAt={dataFavoritedAt}/>, $(this)[0]);
    });

    $('[data-provide="feed-discoverer"]').each(function () {
        const dataUrl = $(this).attr('data-url');
        const dataToken = $('meta[name="csrf-token"]').attr('content');
        const dataSiteInputId = $(this).attr('data-site-input-id');
        const dataFeedInputId = $(this).attr('data-feed-input-id');
        const dataFeedDiscoverButtonContainerId = $(this).attr('data-feed-discover-button-container-id');
        const dataTranslations = JSON.parse($(this).attr('data-translations'));

        ReactDOM.render(
            <FeedDiscoverer
                url={dataUrl}
                token={dataToken}
                siteInputId={dataSiteInputId}
                feedInputId={dataFeedInputId}
                feedDiscoverButtonContainerId={dataFeedDiscoverButtonContainerId}
                translations={dataTranslations}
            />, $(this)[0]);
    });

    tippy('[data-provide-dropdown]', {
        theme: 'dropdown',
        allowHTML: true,
        interactive: true,
        arrow: 'false',
        trigger: 'click',
        placement: 'bottom-start',
        offset: [0, -5],
        animation: 'shift-away-subtle',
        content(reference) {
            let dropdown = document.querySelector(reference.getAttribute('data-dropdown-target'));
            dropdown.classList.remove('hidden');

            return dropdown;
        },
    });
});
