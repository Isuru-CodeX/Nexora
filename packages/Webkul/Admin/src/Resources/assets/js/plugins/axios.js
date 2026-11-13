/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
import axios from "axios";
window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Nexora Global Top Progress Bar
 * Provides instant visual loading feedback across AJAX requests and route navigation.
 */
const TopLoader = {
    bar: null,
    progress: 0,
    timer: null,
    activeCount: 0,

    getBar() {
        if (!this.bar) {
            this.bar = document.getElementById("nexora-top-loader");
        }
        return this.bar;
    },

    start() {
        const bar = this.getBar();
        if (!bar) return;

        this.activeCount++;
        if (this.activeCount > 1) return;

        clearInterval(this.timer);
        this.progress = 16;
        bar.style.transition = "width 220ms cubic-bezier(0.16, 1, 0.3, 1), opacity 180ms ease";
        bar.style.opacity = "1";
        bar.style.width = this.progress + "%";

        this.timer = setInterval(() => {
            if (this.progress < 85) {
                this.progress += Math.floor(Math.random() * 8) + 3;
                if (bar) bar.style.width = this.progress + "%";
            }
        }, 180);
    },

    done() {
        const bar = this.getBar();
        if (!bar) return;

        this.activeCount = Math.max(0, this.activeCount - 1);
        if (this.activeCount > 0) return;

        clearInterval(this.timer);
        this.progress = 100;
        bar.style.transition = "width 180ms ease-out, opacity 280ms ease 120ms";
        bar.style.width = "100%";
        bar.style.opacity = "0";

        setTimeout(() => {
            if (bar && this.activeCount === 0) {
                bar.style.transition = "none";
                bar.style.width = "0%";
                this.progress = 0;
            }
        }, 420);
    },

    pulse(duration = 240) {
        this.start();
        setTimeout(() => {
            this.done();
        }, duration);
    },
};

window.NexoraTopLoader = TopLoader;

// Intercept Axios requests for seamless top loader progress
axios.interceptors.request.use(
    (config) => {
        TopLoader.start();
        return config;
    },
    (error) => {
        TopLoader.done();
        return Promise.reject(error);
    }
);

axios.interceptors.response.use(
    (response) => {
        TopLoader.done();
        return response;
    },
    (error) => {
        TopLoader.done();
        return Promise.reject(error);
    }
);

// Intercept internal anchor clicks, tab changes, and form submissions for instant visual feedback
if (typeof document !== "undefined") {
    // 1. Link / route navigation clicks
    document.addEventListener("click", (e) => {
        // Tab clicks trigger instantaneous micro-loader
        const tabEl = e.target.closest('[role="tab"], .tab-item, [data-tab]');
        if (tabEl) {
            TopLoader.pulse(200);
        }

        const anchor = e.target.closest("a");
        if (!anchor || !anchor.href) return;

        const href = anchor.getAttribute("href");
        if (
            !href ||
            href.startsWith("#") ||
            href.startsWith("javascript:") ||
            anchor.target === "_blank" ||
            anchor.hasAttribute("download")
        ) {
            return;
        }

        try {
            const url = new URL(anchor.href, window.location.href);
            if (url.origin === window.location.origin && url.pathname !== window.location.pathname) {
                if (!e.ctrlKey && !e.metaKey && !e.shiftKey && e.button === 0) {
                    TopLoader.start();
                }
            }
        } catch (err) {}
    });

    // 2. Form submission button loading state & progress
    document.addEventListener("submit", (e) => {
        const form = e.target;
        if (!form) return;

        // Skip background or hidden ping forms if any
        if (form.getAttribute("data-no-loader") !== null) return;

        TopLoader.start();

        const submitBtn = form.querySelector('button[type="submit"], input[type="submit"], button.primary-button');
        if (submitBtn && !submitBtn.classList.contains("btn-loading")) {
            submitBtn.classList.add("btn-loading");
        }
    });

    window.addEventListener("beforeunload", () => {
        TopLoader.start();
    });

    // Reset button loading state on pageshow / bfcache restore
    window.addEventListener("pageshow", () => {
        TopLoader.done();
        document.querySelectorAll(".btn-loading").forEach((btn) => {
            btn.classList.remove("btn-loading");
        });
    });
}

export default {
    install(app) {
        app.config.globalProperties.$axios = axios;
        app.config.globalProperties.$topLoader = TopLoader;
    },
};

