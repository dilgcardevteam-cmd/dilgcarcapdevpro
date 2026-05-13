<style>
    .nav-block {
        min-width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-weight: 700;
        transition: all 0.2s ease;
        border: 1.5px solid transparent;
        font-size: 0.95rem;
    }
    .nav-question {
        background: #f1f5f9;
        color: #475569;
        border-color: #e2e8f0;
    }
    .nav-question:hover {
        background: #e2e8f0;
        color: #1e293b;
        transform: translateY(-1px);
    }
    .nav-question.active {
        background: #10b981;
        color: #fff;
        border-color: #10b981;
        box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2);
    }
    .nav-add {
        background: #002C76;
        color: #fff;
        box-shadow: 0 4px 6px -1px rgba(0, 44, 118, 0.2);
    }
    .nav-add:hover {
        background: #001f54;
        transform: translateY(-1px);
        box-shadow: 0 6px 10px -1px rgba(0, 44, 118, 0.25);
    }
</style>
<script>
    window.CAPDEVQuestionBuilderShared = window.CAPDEVQuestionBuilderShared || (function () {
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
            button.addEventListener('click', onClick);
            return button;
        }

        function createNavAddButton(onClick) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'nav-block nav-add';
            button.innerHTML = '<i class="fas fa-plus"></i>';
            button.addEventListener('click', onClick);
            return button;
        }

        function applyQuestionButtonState(button, isActive) {
            button.classList.toggle('active', isActive);
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


