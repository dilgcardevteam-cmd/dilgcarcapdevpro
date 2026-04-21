<div id="cdp-session-timeout-root" class="cdp-session-timeout-root" aria-hidden="true">
    <div class="cdp-session-timeout-overlay"></div>

    <section class="cdp-session-timeout-card" role="dialog" aria-modal="true" aria-labelledby="cdp-session-timeout-title">
        <button type="button" class="cdp-session-timeout-close" data-session-timeout-continue aria-label="Close session timeout warning">
            <span aria-hidden="true">&times;</span>
        </button>

        <div class="cdp-session-timeout-warning" data-session-timeout-warning>
            <h2 id="cdp-session-timeout-title">You will be logged out soon</h2>
            <p>For your security, we log you out automatically when you have not been active for a certain period of time.</p>

            <div class="cdp-session-timeout-countdown" data-session-timeout-countdown>01:00</div>

            <div class="cdp-session-timeout-actions">
                <button type="button" class="cdp-session-timeout-btn cdp-session-timeout-btn-light" data-session-timeout-logout>
                    Log out now
                </button>
                <button type="button" class="cdp-session-timeout-btn cdp-session-timeout-btn-dark" data-session-timeout-continue>
                    Continue session
                </button>
            </div>
        </div>

        <div class="cdp-session-timeout-ended" data-session-timeout-ended hidden>
            <h2>Session Timeout!</h2>
            <p>You have been logged out due to inactivity</p>

            <div class="cdp-session-timeout-actions cdp-session-timeout-actions-single">
                <a class="cdp-session-timeout-btn cdp-session-timeout-btn-dark" href="{{ route('login') }}">
                    Login
                </a>
            </div>
        </div>
    </section>
</div>

<style>
    .cdp-session-timeout-root {
        position: fixed;
        inset: 0;
        z-index: 2147483000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 24px;
        font-family: "DM Sans", "Inter", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .cdp-session-timeout-root.is-open {
        display: flex;
    }

    .cdp-session-timeout-overlay {
        position: absolute;
        inset: 0;
        background: rgba(229, 231, 235, 0.78);
        backdrop-filter: blur(2px);
        opacity: 0;
        transition: opacity 180ms ease;
    }

    .cdp-session-timeout-card {
        position: relative;
        width: min(100%, 520px);
        box-sizing: border-box;
        border-radius: 20px;
        background: #ffffff;
        padding: 42px 42px 34px;
        box-shadow: 0 24px 70px rgba(15, 23, 42, 0.18), 0 8px 24px rgba(15, 23, 42, 0.08);
        color: #111827;
        text-align: center;
        opacity: 0;
        transform: translateY(10px) scale(0.96);
        transition: opacity 180ms ease, transform 180ms ease;
    }

    .cdp-session-timeout-root.is-open .cdp-session-timeout-overlay,
    .cdp-session-timeout-root.is-open .cdp-session-timeout-card {
        opacity: 1;
    }

    .cdp-session-timeout-root.is-open .cdp-session-timeout-card {
        transform: translateY(0) scale(1);
    }

    .cdp-session-timeout-close {
        position: absolute;
        top: 18px;
        right: 18px;
        width: 34px;
        height: 34px;
        border: 0;
        border-radius: 8px;
        background: transparent;
        color: #9ca3af;
        cursor: pointer;
        font-size: 30px;
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: background-color 160ms ease, color 160ms ease;
    }

    .cdp-session-timeout-close:hover {
        background: #f3f4f6;
        color: #4b5563;
    }

    .cdp-session-timeout-card h2 {
        margin: 0;
        font-size: 27px;
        line-height: 1.22;
        font-weight: 800;
        letter-spacing: 0;
        color: #0f172a;
    }

    .cdp-session-timeout-card p {
        max-width: 410px;
        margin: 14px auto 0;
        font-size: 15px;
        line-height: 1.65;
        font-weight: 400;
        color: #6b7280;
    }

    .cdp-session-timeout-countdown {
        margin: 30px auto 32px;
        font-size: 58px;
        line-height: 1;
        font-weight: 900;
        letter-spacing: 0;
        color: #0f172a;
        font-variant-numeric: tabular-nums;
    }

    .cdp-session-timeout-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .cdp-session-timeout-actions-single {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }

    .cdp-session-timeout-btn {
        min-height: 50px;
        border-radius: 8px;
        padding: 13px 20px;
        border: 1px solid transparent;
        font: inherit;
        font-size: 15px;
        font-weight: 800;
        letter-spacing: 0;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: transform 160ms ease, box-shadow 160ms ease, background-color 160ms ease, border-color 160ms ease;
    }

    .cdp-session-timeout-btn:hover {
        transform: translateY(-1px);
    }

    .cdp-session-timeout-btn-light {
        background: #ffffff;
        border-color: #d1d5db;
        color: #111827;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
    }

    .cdp-session-timeout-btn-light:hover {
        background: #f9fafb;
        border-color: #9ca3af;
    }

    .cdp-session-timeout-btn-dark {
        background: #00327d;
        border-color: #00327d;
        color: #ffffff;
        box-shadow: 0 10px 22px rgba(0, 50, 125, 0.22);
    }

    .cdp-session-timeout-btn-dark:hover {
        background: #002966;
        border-color: #002966;
    }

    .cdp-session-timeout-ended .cdp-session-timeout-btn-dark {
        min-width: 180px;
    }

    @media (max-width: 560px) {
        .cdp-session-timeout-root {
            padding: 18px;
        }

        .cdp-session-timeout-card {
            border-radius: 18px;
            padding: 38px 22px 24px;
        }

        .cdp-session-timeout-card h2 {
            font-size: 23px;
        }

        .cdp-session-timeout-card p {
            font-size: 14px;
        }

        .cdp-session-timeout-countdown {
            margin: 26px auto 28px;
            font-size: 48px;
        }

        .cdp-session-timeout-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    @php
        $inactivityWarningMilliseconds = \App\Http\Middleware\CheckInactivityTimeout::INACTIVITY_WARNING_SECONDS * 1000;
        $logoutCountdownMilliseconds = \App\Http\Middleware\CheckInactivityTimeout::LOGOUT_COUNTDOWN_SECONDS * 1000;
    @endphp

    window.CAPDEV_SESSION_TIMEOUT = {
        inactivityWarningAfter: {{ $inactivityWarningMilliseconds }},
        logoutCountdown: {{ $logoutCountdownMilliseconds }},
        keepAliveThrottle: 60000,
        keepAliveUrl: @json(route('session.keep-alive')),
        logoutUrl: @json(route('logout')),
        loginUrl: @json(route('login')),
        csrfToken: @json(csrf_token())
    };
</script>

<script>
    (function () {
        if (window.sessionTimeoutInitialized === true) {
            document.querySelectorAll('#cdp-session-timeout-root').forEach(function (node, index) {
                if (index > 0) node.remove();
            });
            return;
        }

        window.sessionTimeoutInitialized = true;

        const config = window.CAPDEV_SESSION_TIMEOUT || {};
        const roots = document.querySelectorAll('#cdp-session-timeout-root');
        const root = roots[0];

        roots.forEach(function (node, index) {
            if (index > 0) {
                node.remove();
            }
        });

        if (!root) {
            return;
        }

        root.dataset.bound = 'true';

        const warningPanel = root.querySelector('[data-session-timeout-warning]');
        const endedPanel = root.querySelector('[data-session-timeout-ended]');
        const countdown = root.querySelector('[data-session-timeout-countdown]');
        const continueButtons = root.querySelectorAll('[data-session-timeout-continue]');
        const logoutButton = root.querySelector('[data-session-timeout-logout]');
        const closeButton = root.querySelector('.cdp-session-timeout-close');
        const activityEvents = [
            'mousemove',
            'pointermove',
            'click',
            'mousedown',
            'keydown',
            'keypress',
            'input',
            'touchstart',
            'scroll',
            'wheel'
        ];

        const inactivityWarningAfter = Number(config.inactivityWarningAfter || 1800000);
        const logoutCountdownDuration = Number(config.logoutCountdown || 60000);

        let inactivityTimer = null;
        let countdownTimer = null;
        let logoutAt = 0;
        let warningVisible = false;
        let sessionEnded = false;
        let keepAliveInFlight = false;
        let logoutInFlight = false;
        let lastKeepAliveAt = Date.now();

        function headers() {
            return {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': config.csrfToken || '',
                'X-Requested-With': 'XMLHttpRequest'
            };
        }

        function formatTime(milliseconds) {
            const totalSeconds = Math.max(0, Math.ceil(milliseconds / 1000));
            const minutes = String(Math.floor(totalSeconds / 60)).padStart(2, '0');
            const seconds = String(totalSeconds % 60).padStart(2, '0');
            return minutes + ':' + seconds;
        }

        function setCountdown() {
            if (countdown) {
                countdown.textContent = formatTime(logoutAt - Date.now());
            }
        }

        function clearTimers() {
            window.clearTimeout(inactivityTimer);
            window.clearInterval(countdownTimer);
            inactivityTimer = null;
            countdownTimer = null;
        }

        function openWarning() {
            if (sessionEnded || warningVisible) {
                return;
            }

            warningVisible = true;
            window.clearInterval(countdownTimer);
            logoutAt = Date.now() + logoutCountdownDuration;
            warningPanel.hidden = false;
            endedPanel.hidden = true;
            closeButton.hidden = false;
            root.classList.add('is-open');
            root.setAttribute('aria-hidden', 'false');
            setCountdown();
            countdownTimer = window.setInterval(function () {
                setCountdown();
                if (Date.now() >= logoutAt) {
                    performTimeoutLogout();
                }
            }, 1000);
        }

        function closeWarning() {
            warningVisible = false;
            root.classList.remove('is-open');
            root.setAttribute('aria-hidden', 'true');
            window.clearInterval(countdownTimer);
        }

        function scheduleInactivityTimer() {
            clearTimers();
            inactivityTimer = window.setTimeout(openWarning, inactivityWarningAfter);
        }

        function resetLocalTimer() {
            if (sessionEnded) {
                return;
            }

            closeWarning();
            scheduleInactivityTimer();
        }

        function keepSessionAlive(onSuccess, onFailure) {
            if (keepAliveInFlight || sessionEnded) {
                return;
            }

            keepAliveInFlight = true;
            fetch(config.keepAliveUrl, {
                method: 'POST',
                headers: headers(),
                body: JSON.stringify({ keep_alive: true }),
                credentials: 'same-origin'
            }).then(function (response) {
                if (!response.ok) {
                    throw new Error('Session keep-alive failed.');
                }

                lastKeepAliveAt = Date.now();
                resetLocalTimer();
                if (typeof onSuccess === 'function') {
                    onSuccess(response);
                }
            }).catch(function () {
                if (typeof onFailure === 'function') {
                    onFailure();
                    return;
                }

                showTimedOut();
            }).finally(function () {
                keepAliveInFlight = false;
            });
        }

        function showTimedOut() {
            sessionEnded = true;
            warningVisible = false;
            clearTimers();
            warningPanel.hidden = true;
            endedPanel.hidden = false;
            closeButton.hidden = true;
            root.classList.add('is-open');
            root.setAttribute('aria-hidden', 'false');
        }

        function postLogout() {
            return fetch(config.logoutUrl, {
                method: 'POST',
                headers: headers(),
                body: JSON.stringify({}),
                credentials: 'same-origin'
            });
        }

        function performTimeoutLogout() {
            if (sessionEnded || logoutInFlight) {
                return;
            }

            logoutInFlight = true;
            clearTimers();
            postLogout().finally(showTimedOut);
        }

        function performManualLogout() {
            if (logoutInFlight) {
                return;
            }

            logoutInFlight = true;
            sessionEnded = true;
            clearTimers();
            postLogout().finally(function () {
                window.location.href = config.loginUrl || '/login';
            });
        }

        activityEvents.forEach(function (eventName) {
            window.addEventListener(eventName, function () {
                if (sessionEnded) {
                    return;
                }

                if (!warningVisible) {
                    scheduleInactivityTimer();
                }

                if (!warningVisible && (Date.now() - lastKeepAliveAt) >= (config.keepAliveThrottle || 60000)) {
                    keepSessionAlive(function () {}, function () {});
                }
            }, { passive: true });
        });

        continueButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                keepSessionAlive(null, showTimedOut);
            });
        });

        if (logoutButton) {
            logoutButton.addEventListener('click', performManualLogout);
        }

        scheduleInactivityTimer();
    })();
</script>
