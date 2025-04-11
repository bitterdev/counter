$(document).ready(function () {
    function animateCounter($counter, duration) {
        const target = parseInt($counter.data("target-value"));
        const start = performance.now();

        function update(now) {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const currentValue = Math.floor(progress * target);

            $counter.text(currentValue);

            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                $counter.text(target);
            }
        }

        requestAnimationFrame(update);
    }

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const $container = $(entry.target);
                const duration = parseInt($container.closest('.counter-container').data("duration"));

                $container.find('.counter-value').each(function () {
                    if (!$(this).hasClass('counted')) {
                        animateCounter($(this), duration);
                        $(this).addClass('counted');
                    }
                });

                obs.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.5
    });

    $('.counter').each(function () {
        observer.observe(this);
    });
});
