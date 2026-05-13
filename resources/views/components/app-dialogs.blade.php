<div id="capdev-app-dialog-root" class="capdev-app-dialog-root" aria-hidden="true">
    <div class="capdev-app-dialog-backdrop"></div>
    <section class="capdev-app-dialog" role="dialog" aria-modal="true" aria-labelledby="capdev-app-dialog-title">
        <div class="capdev-app-dialog-header">
            <div class="capdev-app-dialog-badge" data-dialog-badge aria-hidden="true">!</div>
            <div class="capdev-app-dialog-header-copy">
                <h2 id="capdev-app-dialog-title">Notice</h2>
                <p class="capdev-app-dialog-subtitle" data-dialog-subtitle>Please review this action before continuing.</p>
            </div>
        </div>
        <p class="capdev-app-dialog-message" data-dialog-message></p>
        <label class="capdev-app-dialog-input-wrap" data-dialog-input-wrap hidden>
            <span class="capdev-app-dialog-input-label" data-dialog-input-label>Value</span>
            <input type="text" class="capdev-app-dialog-input" data-dialog-input>
        </label>
        <div class="capdev-app-dialog-actions">
            <button type="button" class="capdev-app-dialog-btn capdev-app-dialog-btn-secondary" data-dialog-cancel hidden>Cancel</button>
            <button type="button" class="capdev-app-dialog-btn capdev-app-dialog-btn-primary" data-dialog-confirm>OK</button>
        </div>
    </section>
</div>

<style>
    .capdev-app-dialog-root {
        position: fixed;
        inset: 0;
        z-index: 2147483000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.2s ease, visibility 0.2s ease;
    }

    .capdev-app-dialog-root.is-open {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .capdev-app-dialog-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.48);
    }

    .capdev-app-dialog {
        position: relative;
        width: min(100%, 500px);
        max-height: calc(100vh - 40px);
        overflow: auto;
        background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        color: #0f172a;
        border-radius: 8px;
        padding: 24px 24px 22px;
        border: 1px solid #dbe7f3;
        box-shadow: 0 24px 50px rgba(15, 23, 42, 0.18);
        font-family: inherit;
    }

    .capdev-app-dialog-header {
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }

    .capdev-app-dialog-badge {
        flex: 0 0 auto;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #dbeafe;
        color: #1d4ed8;
        font-size: 1.1rem;
        font-weight: 800;
        box-shadow: inset 0 0 0 1px rgba(37, 99, 235, 0.08);
    }

    .capdev-app-dialog-header-copy {
        min-width: 0;
    }

    .capdev-app-dialog-header h2 {
        margin: 0;
        font-size: 1.2rem;
        line-height: 1.3;
        color: #0f172a;
    }

    .capdev-app-dialog-subtitle {
        margin: 4px 0 0;
        font-size: 0.9rem;
        line-height: 1.5;
        color: #64748b;
    }

    .capdev-app-dialog-message {
        margin: 16px 0 0;
        font-size: 0.98rem;
        line-height: 1.65;
        color: #334155;
        white-space: pre-wrap;
        word-break: break-word;
    }

    .capdev-app-dialog-input-wrap {
        display: block;
        margin-top: 18px;
        padding: 14px;
        background: rgba(255, 255, 255, 0.82);
        border: 1px solid #dbe7f3;
        border-radius: 8px;
    }

    .capdev-app-dialog-input-label {
        display: block;
        margin-bottom: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        color: #475569;
    }

    .capdev-app-dialog-input {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 12px 14px;
        font: inherit;
        color: #0f172a;
        outline: none;
        box-sizing: border-box;
    }

    .capdev-app-dialog-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.16);
    }

    .capdev-app-dialog-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 22px;
    }

    .capdev-app-dialog-btn {
        min-width: 104px;
        border: none;
        border-radius: 8px;
        padding: 11px 18px;
        font: inherit;
        font-weight: 700;
        cursor: pointer;
        transition: filter 0.15s ease, transform 0.15s ease;
    }

    .capdev-app-dialog-btn:hover {
        filter: brightness(0.98);
    }

    .capdev-app-dialog-btn:active {
        transform: translateY(1px);
    }

    .capdev-app-dialog-btn-primary {
        background: #2563eb;
        color: #ffffff;
    }

    .capdev-app-dialog-root[data-variant="danger"] .capdev-app-dialog-badge {
        background: #fee2e2;
        color: #b91c1c;
        box-shadow: inset 0 0 0 1px rgba(185, 28, 28, 0.08);
    }

    .capdev-app-dialog-root[data-variant="danger"] .capdev-app-dialog-btn-primary {
        background: #dc2626;
    }

    .capdev-app-dialog-root[data-variant="prompt"] .capdev-app-dialog-badge {
        background: #dcfce7;
        color: #15803d;
        box-shadow: inset 0 0 0 1px rgba(21, 128, 61, 0.08);
    }

    .capdev-app-dialog-input-wrap[hidden] {
        display: none !important;
    }

    .capdev-app-dialog-btn[hidden] {
        display: none !important;
    }

    .capdev-app-dialog-btn-secondary {
        background: #e2e8f0;
        color: #0f172a;
    }

    @media (max-width: 640px) {
        .capdev-app-dialog-root {
            padding: 16px;
        }

        .capdev-app-dialog {
            padding: 20px;
        }

        .capdev-app-dialog-actions {
            flex-direction: column-reverse;
        }

        .capdev-app-dialog-btn {
            width: 100%;
        }
    }
</style>

<script>
    (function () {
        const root = document.getElementById('capdev-app-dialog-root');

        if (!root || root.dataset.bound === 'true') {
            return;
        }

        root.dataset.bound = 'true';

        const title = root.querySelector('#capdev-app-dialog-title');
        const subtitle = root.querySelector('[data-dialog-subtitle]');
        const badge = root.querySelector('[data-dialog-badge]');
        const message = root.querySelector('[data-dialog-message]');
        const inputWrap = root.querySelector('[data-dialog-input-wrap]');
        const inputLabel = root.querySelector('[data-dialog-input-label]');
        const input = root.querySelector('[data-dialog-input]');
        const cancelButton = root.querySelector('[data-dialog-cancel]');
        const confirmButton = root.querySelector('[data-dialog-confirm]');

        let activeDialog = null;
        let lastFocusedElement = null;

        function resolveVariant(config) {
            if (config.variant) {
                return config.variant;
            }

            const titleText = String(config.title || '').toLowerCase();
            const confirmText = String(config.confirmText || '').toLowerCase();
            const messageText = String(config.message || '').toLowerCase();
            const dangerHints = ['delete', 'remove', 'revoke', 'reset', 'permanent', 'archive'];

            if (config.type === 'prompt') {
                return 'prompt';
            }

            if (dangerHints.some(function (hint) {
                return titleText.includes(hint) || confirmText.includes(hint) || messageText.includes(hint);
            })) {
                return 'danger';
            }

            return 'default';
        }

        function openDialog(config) {
            if (activeDialog) {
                activeDialog.resolve(activeDialog.type === 'prompt' ? null : false);
                closeDialog();
            }

            lastFocusedElement = document.activeElement instanceof HTMLElement ? document.activeElement : null;
            activeDialog = config;

            title.textContent = config.title || 'Notice';
            subtitle.textContent = config.subtitle || (config.type === 'prompt'
                ? 'Fill in the required detail below.'
                : 'Please review this action before continuing.');
            message.textContent = config.message || '';
            confirmButton.textContent = config.confirmText || 'OK';
            cancelButton.textContent = config.cancelText || 'Cancel';
            cancelButton.hidden = config.type === 'alert';
            inputWrap.hidden = config.type !== 'prompt';
            input.value = config.defaultValue || '';
            inputLabel.textContent = config.inputLabel || 'Input';
            badge.textContent = config.badge || (config.type === 'prompt' ? '+' : '!');
            root.dataset.variant = resolveVariant(config);

            root.classList.add('is-open');
            root.setAttribute('aria-hidden', 'false');

            window.setTimeout(function () {
                if (config.type === 'prompt') {
                    input.focus();
                    input.select();
                } else {
                    confirmButton.focus();
                }
            }, 0);
        }

        function closeDialog() {
            root.classList.remove('is-open');
            root.setAttribute('aria-hidden', 'true');
            delete root.dataset.variant;
            input.value = '';

            if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') {
                lastFocusedElement.focus();
            }

            activeDialog = null;
        }

        function resolveDialog(value) {
            if (!activeDialog) {
                return;
            }

            const dialog = activeDialog;
            closeDialog();
            dialog.resolve(value);
        }

        confirmButton.addEventListener('click', function () {
            if (!activeDialog) {
                return;
            }

            resolveDialog(activeDialog.type === 'prompt' ? input.value : true);
        });

        cancelButton.addEventListener('click', function () {
            if (!activeDialog) {
                return;
            }

            resolveDialog(activeDialog.type === 'prompt' ? null : false);
        });

        root.addEventListener('click', function (event) {
            if (event.target === root || event.target.classList.contains('capdev-app-dialog-backdrop')) {
                if (activeDialog && activeDialog.type !== 'alert') {
                    resolveDialog(activeDialog.type === 'prompt' ? null : false);
                }
            }
        });

        document.addEventListener('keydown', function (event) {
            if (!activeDialog) {
                return;
            }

            if (event.key === 'Escape' && activeDialog.type !== 'alert') {
                event.preventDefault();
                resolveDialog(activeDialog.type === 'prompt' ? null : false);
                return;
            }

            if (event.key === 'Enter' && activeDialog.type === 'prompt' && document.activeElement === input) {
                event.preventDefault();
                resolveDialog(input.value);
            }
        });

        window.CapdevDialog = {
            alert: function (dialogMessage, options) {
                return new Promise(function (resolve) {
                    openDialog({
                        type: 'alert',
                        title: options && options.title ? options.title : 'Notice',
                        message: String(dialogMessage ?? ''),
                        confirmText: options && options.confirmText ? options.confirmText : 'OK',
                        resolve: resolve
                    });
                });
            },
            confirm: function (dialogMessage, options) {
                return new Promise(function (resolve) {
                    openDialog({
                        type: 'confirm',
                        title: options && options.title ? options.title : 'Confirm',
                        message: String(dialogMessage ?? ''),
                        confirmText: options && options.confirmText ? options.confirmText : 'OK',
                        cancelText: options && options.cancelText ? options.cancelText : 'Cancel',
                        resolve: resolve
                    });
                });
            },
            prompt: function (dialogMessage, defaultValue, options) {
                return new Promise(function (resolve) {
                    openDialog({
                        type: 'prompt',
                        title: options && options.title ? options.title : 'Input Needed',
                        message: String(dialogMessage ?? ''),
                        confirmText: options && options.confirmText ? options.confirmText : 'Save',
                        cancelText: options && options.cancelText ? options.cancelText : 'Cancel',
                        defaultValue: defaultValue == null ? '' : String(defaultValue),
                        inputLabel: options && options.inputLabel ? options.inputLabel : 'Value',
                        resolve: resolve
                    });
                });
            }
        };

        window.capdevConfirm = function (dialogMessage, options) {
            return window.CapdevDialog.confirm(dialogMessage, options);
        };

        window.capdevPrompt = function (dialogMessage, defaultValue, options) {
            return window.CapdevDialog.prompt(dialogMessage, defaultValue, options);
        };

        window.alert = function (dialogMessage) {
            window.CapdevDialog.alert(dialogMessage);
        };

        document.addEventListener('submit', function (event) {
            const form = event.target;
            const submitter = event.submitter instanceof HTMLElement ? event.submitter : null;

            if (!(form instanceof HTMLFormElement)) {
                return;
            }

            if (form.dataset.confirmBypass === 'true') {
                form.dataset.confirmBypass = 'false';
                return;
            }

            const messageText = form.dataset.confirmMessage;

            if (!messageText) {
                return;
            }

            if (form.dataset.confirmStopPropagation === 'true') {
                event.stopPropagation();
            }

            event.preventDefault();

            window.CapdevDialog.confirm(messageText, {
                title: form.dataset.confirmTitle || 'Confirm',
                confirmText: form.dataset.confirmOk || 'OK',
                cancelText: form.dataset.confirmCancel || 'Cancel'
            }).then(function (confirmed) {
                if (!confirmed) {
                    return;
                }

                const actionAttribute = form.getAttribute('action');
                const effectiveAction = submitter && typeof submitter.getAttribute === 'function' && submitter.getAttribute('formaction')
                    ? submitter.getAttribute('formaction')
                    : actionAttribute;

                if (!effectiveAction || !String(effectiveAction).trim()) {
                    window.CapdevDialog.alert('This action is not ready yet. Please reopen the item and try again.', {
                        title: 'Action Unavailable'
                    });
                    return;
                }

                form.dataset.confirmBypass = 'true';

                if (typeof form.requestSubmit === 'function') {
                    form.requestSubmit(submitter || undefined);
                    return;
                }

                form.submit();
                form.dataset.confirmBypass = 'false';
            });
        }, true);
    })();
</script>


