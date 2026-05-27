export function useFormatters() {
    const formatPrice = (value) =>
        'Rp\u00a0' + new Intl.NumberFormat('id-ID').format(value ?? 0);

    const formatDate = (dateStr, opts = {}) => {
        if (!dateStr) return '-';
        return new Date(dateStr).toLocaleDateString('id-ID', {
            day: 'numeric', month: 'long', year: 'numeric', ...opts,
        });
    };

    const formatTime = (timeStr) => {
        if (!timeStr) return '-';
        return timeStr.slice(0, 5);
    };

    return { formatPrice, formatDate, formatTime };
}
