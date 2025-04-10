$(document).ready(function () {
    function animateCounter($counter, duration) {
        var target = parseInt($counter.data("target-value"));
        var current = 0;
        var stepTime = Math.max(Math.floor(duration / target), 10);

        var interval = setInterval(function () {
            current++;
            $counter.text(current);

            if (current >= target) {
                clearInterval(interval);
            }
        }, stepTime);
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

                obs.unobserve(entry.target); // Nur einmal zählen
            }
        });
    }, {
        threshold: 0.5 // Element muss zu 50% sichtbar sein
    });

    $('.counter').each(function () {
        observer.observe(this);
    });
});