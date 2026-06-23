@props([
    'action' => '',
    'method' => 'POST',
    'submitText' => 'Сохранить',
    'loadUrl' => null,
    'initialData' => '{}',
    'redirectTo' => '/',
])

<div
    x-data="dynamicForm(
        '{{ $action }}',
        '{{ $method }}',
        '{{ $loadUrl }}',
        {{ $initialData }},
        '{{ $redirectTo }}'
    )"
    x-init="init()"
>
    <div
        x-show="error"
        style="display: none; background: #fee; padding: 1rem; margin-bottom: 1rem; border-radius: 6px; color: #c33;"
        x-html="error"
    ></div>

    <form @submit.prevent="submitForm">
        {{ $slot }}

        <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary">{{ $submitText }}</button>
            <a href="{{ $redirectTo }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>

@once
@push('scripts')
<script>
function dynamicForm(action, method, loadUrl, initialData, redirectTo) {
    return {
        form: { ...initialData },
        error: '',
        action,
        method,
        loadUrl,
        redirectTo,

        async init() {
            if (!this.loadUrl) return;

            try {
                const response = await fetch(this.loadUrl);
                const data = await response.json();
                const item = data.data || data;

                for (const key of Object.keys(this.form)) {
                    if (item[key] !== undefined) {
                        let val = item[key];
                        // datetime-local fix
                        if (key.includes('date') && val) {
                            val = val.replace(' ', 'T').slice(0, 16);
                        }
                        this.form[key] = val;
                    }
                }
            } catch (err) {
                console.error('Ошибка загрузки данных', err);
                this.error = 'Не удалось загрузить данные';
            }
        },

        async submitForm() {
            this.error = '';
            const payload = { ...this.form };

            // Преобразуем даты обратно для API
            for (const key of Object.keys(payload)) {
                if (payload[key] && typeof payload[key] === 'string' && payload[key].includes('T')) {
                    payload[key] = payload[key].replace('T', ' ') + ':00';
                }
            }

            try {
                const response = await fetch(this.action, {
                    method: this.method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                if (response.ok) {
                    window.location.href = this.redirectTo;
                } else {
                    const err = await response.json();
                    if (err.errors) {
                        const messages = [];
                        for (const [field, errors] of Object.entries(err.errors)) {
                            errors.forEach(msg => messages.push(msg));
                        }
                        this.error = messages.join('<br>');
                    } else {
                        this.error = err.message || 'Произошла ошибка';
                    }
                }
            } catch (err) {
                console.error('Ошибка отправки', err);
                this.error = 'Сетевая ошибка';
            }
        },
    };
}
</script>
@endonce
