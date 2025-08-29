class ConfettiFull {
    constructor(el) {
        this.el = el;
        this.containerEl = null;

        this.confettiFrequency = 3;
        this.confettiColors = ["#FCE18A", "#FF726D", "#B48DEF", "#F4306D"];
        this.confettiAnimations = ["slow", "medium", "fast"];
        this.confettiInterval = null;

        this._setupElements();
    }

    _setupElements() {
        const containerEl = document.createElement("div");
        const elPosition = this.el.style.position;

        if (elPosition !== "relative" && elPosition !== "absolute") {
            this.el.style.position = "relative";
        }

        containerEl.classList.add("confetti-container");
        this.el.appendChild(containerEl);
        this.containerEl = containerEl;
    }

    _renderConfetti() {
        const confettiEl = document.createElement("div");
        const confettiSize = Math.floor(Math.random() * 3) + 7 + "px";
        const ConfettiBackground = this.confettiColors[
            Math.floor(Math.random() * this.confettiColors.length)
        ];

        const confettiLeft =
            Math.floor(Math.random() * this.el.offsetWidth) + "px";
        const confettiAnimation = this.confettiAnimations[
            Math.floor(Math.random() * this.confettiAnimations.length)
        ];

        confettiEl.classList.add(
            "confetti",
            "confetti--animation-" + confettiAnimation
        );

        confettiEl.style.left = confettiLeft;
        confettiEl.style.width = confettiSize;
        confettiEl.style.height = confettiSize;
        confettiEl.style.backgroundColor = ConfettiBackground;

        confettiEl.removeTimeout = setTimeout(function () {
            confettiEl.parentNode.removeChild(confettiEl);
        }, 3000);

        this.containerEl.appendChild(confettiEl);
    }

    start() {
        if (this.confettiInterval) return; // Ya está corriendo
        this.confettiInterval = setInterval(() => {
            this._renderConfetti();
        }, 25);
    }

    stop() {
        clearInterval(this.confettiInterval);
        this.confettiInterval = null;
    }
}

//CONFETIS FELICITACIONES
function activeCongratulations(selector, enable) {
    const element = document.querySelector(selector);
    if (!element) return;

    // Si no existe aún, guardamos el confetti en dataset del elemento
    if (!element._confettiInstance) {
        element._confettiInstance = new ConfettiFull(element);
    }

    if (enable) {
        element._confettiInstance.start();
    } else {
        element._confettiInstance.stop();
    }
}