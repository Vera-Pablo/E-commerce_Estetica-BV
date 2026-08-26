/*! instant.page v5.2.0 - (C) 2019-2023 Alexandre Dieulot - https://instant.page/license */

(function () {
    // If Speculation Rules API is supported by the browser, let it handle prefetching natively
    if (typeof HTMLScriptElement !== 'undefined' && HTMLScriptElement.supports && HTMLScriptElement.supports('speculationrules')) {
        return;
    }

    let mouseoverTimer;
    let lastTouchTimestamp;
    const prefetchedUrls = new Set();

    const isSupported = 'withCredentials' in new XMLHttpRequest() || 'fetch' in window;
    if (!isSupported) {
        return;
    }

    const delayOnHover = 65;

    function init() {
        document.addEventListener('touchstart', touchstartListener, { passive: true });
        document.addEventListener('mouseover', mouseoverListener, { passive: true });
    }

    function touchstartListener(event) {
        lastTouchTimestamp = performance.now();
        const anchor = event.target.closest('a');
        if (!isPreloadable(anchor)) {
            return;
        }
        preload(anchor.href);
    }

    function mouseoverListener(event) {
        if (performance.now() - lastTouchTimestamp < 1100) {
            return;
        }
        const anchor = event.target.closest('a');
        if (!isPreloadable(anchor)) {
            return;
        }

        anchor.addEventListener('mouseout', mouseoutListener, { passive: true });

        mouseoverTimer = setTimeout(() => {
            preload(anchor.href);
            mouseoverTimer = undefined;
        }, delayOnHover);
    }

    function mouseoutListener(event) {
        if (event.relatedTarget && event.target.closest('a') === event.relatedTarget.closest('a')) {
            return;
        }
        if (mouseoverTimer) {
            clearTimeout(mouseoverTimer);
            mouseoverTimer = undefined;
        }
    }

    function isPreloadable(anchor) {
        if (!anchor || !anchor.href) {
            return false;
        }

        if (anchor.hasAttribute('data-no-instant') || anchor.hasAttribute('download')) {
            return false;
        }

        const url = new URL(anchor.href, location.href);

        if (url.origin !== location.origin) {
            return false;
        }

        if (url.pathname === location.pathname && url.search === location.search) {
            return false;
        }

        if (url.hash && url.pathname === location.pathname && url.search === location.search) {
            return false;
        }

        // Exclude action / state mutating URLs
        const excludedPatterns = [
            /\/logout$/i,
            /\/guardar$/i,
            /\/editar\//i,
            /\/cambiar-estado$/i,
            /\/eliminar\//i,
            /\/auth\//i,
            /\/registro\/validar\//i,
            /\/recuperar\/confirmar\//i
        ];

        for (const pattern of excludedPatterns) {
            if (pattern.test(url.pathname)) {
                return false;
            }
        }

        return true;
    }

    function preload(url) {
        if (prefetchedUrls.has(url)) {
            return;
        }

        const link = document.createElement('link');
        link.rel = 'prefetch';
        link.href = url;
        document.head.appendChild(link);

        prefetchedUrls.add(url);
    }

    init();
})();
