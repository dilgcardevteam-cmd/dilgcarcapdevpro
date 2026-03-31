<script>
    window.CAPDEVQuestionBuilderShared = window.CAPDEVQuestionBuilderShared || (function () {
        const questionButtonStyle = 'min-width:36px;height:36px;border-radius:10px;border:1px solid #60a5fa;background:#3b82f6;color:#fff;font-weight:700;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 2px 6px rgba(59,130,246,.25);';
        const addButtonStyle = 'min-width:36px;height:36px;border-radius:10px;border:1px solid #0f3b8f;background:#0f3b8f;color:#fff;font-weight:800;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 2px 6px rgba(15,59,143,.25);';

        function getPointsInput(scope) {
            const type = scope.querySelector('.eq-type')?.value || 'multiple_choice';
            if (type === 'essay') return scope.querySelector('.eq-essay-points');
            if (type === 'enumeration') return scope.querySelector('.eq-enum-points');
            return scope.querySelector('.eq-common-points');
        }

        function syncPointsValidation(scope) {
            const active = getPointsInput(scope);
            scope.querySelectorAll('.eq-common-points, .eq-essay-points, .eq-enum-points').forEach((input) => {
                input.required = input === active;
                if (input !== active) input.setCustomValidity('');
            });
        }

        function validatePoints(scope) {
            syncPointsValidation(scope);
            const input = getPointsInput(scope);
            if (!input) return true;
            const hasValue = String(input.value || '').trim() !== '';
            input.setCustomValidity(hasValue ? '' : 'Points field is required.');
            if (!hasValue) {
                input.reportValidity();
                input.focus();
                return false;
            }
            return true;
        }

        function createNavQuestionButton(index, onClick) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'nav-block nav-question';
            button.textContent = String(index + 1);
            button.style.cssText = questionButtonStyle;
            button.addEventListener('click', onClick);
            return button;
        }

        function createNavAddButton(onClick) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'nav-block nav-add';
            button.textContent = '+';
            button.style.cssText = addButtonStyle;
            button.addEventListener('click', onClick);
            return button;
        }

        function applyQuestionButtonState(button, isActive) {
            button.classList.toggle('active', isActive);
            if (isActive) {
                button.style.background = '#10b981';
                button.style.borderColor = '#10b981';
                button.style.boxShadow = '0 2px 6px rgba(16,185,129,.25)';
            } else {
                button.style.background = '#3b82f6';
                button.style.borderColor = '#60a5fa';
                button.style.boxShadow = '0 2px 6px rgba(59,130,246,.2)';
            }
        }

        return {
            getPointsInput,
            syncPointsValidation,
            validatePoints,
            createNavQuestionButton,
            createNavAddButton,
            applyQuestionButtonState,
        };
    })();
</script>
