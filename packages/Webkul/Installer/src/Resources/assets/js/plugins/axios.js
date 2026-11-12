import axios from "axios";
window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

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
};

window.NexoraTopLoader = TopLoader;

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

export default {
    install(app) {
        app.config.globalProperties.$axios = axios;
        app.config.globalProperties.$topLoader = TopLoader;
    },
};

