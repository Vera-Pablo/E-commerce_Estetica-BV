class ToastHelper {
    static containerId = 'toast-container-global';

    static getOrCreateContainer() {
        let container = document.getElementById(this.containerId);
        if (!container) {
            container = document.createElement('div');
            container.id = this.containerId;
            container.className = 'toast-container position-fixed p-3';
            container.style.cssText = 'position: fixed !important; top: 20px !important; right: 20px !important; z-index: 999999 !important; pointer-events: none;';
            document.body.appendChild(container);
        }
        return container;
    }

    static show(type, message) {
        if (!message) return;
        
        const container = this.getOrCreateContainer();

        let iconColor = '';
        let svgIcon = '';

        if (type === 'success') {
            iconColor = '#198754';
            svgIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="${iconColor}" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>`;
        } else if (type === 'error') {
            iconColor = '#dc3545';
            svgIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="${iconColor}" class="bi bi-x-circle-fill me-2" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
            </svg>`;
        } else if (type === 'warning') {
            iconColor = '#ffc107';
            svgIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="${iconColor}" class="bi bi-exclamation-triangle-fill me-2" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>`;
        }

        const toastEl = document.createElement('div');
        toastEl.className = 'toast';
        toastEl.setAttribute('role', 'alert');
        toastEl.setAttribute('aria-live', 'assertive');
        toastEl.setAttribute('aria-atomic', 'true');
        toastEl.setAttribute('data-bs-delay', '6000'); // 6 seconds duration
        toastEl.style.cssText = 'pointer-events: auto; z-index: 999999 !important; box-shadow: 0 10px 30px rgba(0,0,0,0.35) !important; background-color: #ffffff !important;';

        toastEl.innerHTML = `
            <div class="toast-header">
                ${svgIcon}
                <strong class="me-auto">¡Aviso!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        `;

        container.appendChild(toastEl);

        const bsToast = new bootstrap.Toast(toastEl);
        bsToast.show();

        // Remove from DOM when completely hidden
        toastEl.addEventListener('hidden.bs.toast', () => {
            toastEl.remove();
        });
    }
}

// Automatically trigger toasts from CodeIgniter 4 session flash elements
document.addEventListener('DOMContentLoaded', () => {
    ['success', 'error', 'warning'].forEach(type => {
        const el = document.getElementById(`flash-${type}`);
        if (el) {
            const message = el.value || el.getAttribute('data-message') || el.innerText;
            if (message && message.trim() !== '') {
                ToastHelper.show(type, message);
            }
        }
    });
});
