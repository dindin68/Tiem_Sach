document.addEventListener('DOMContentLoaded', function () {
    let rowIndex = 0;
    const rows = document.getElementById('product-rows');
    const totalEl = document.getElementById('total-amount');
    const template = document.getElementById('book-row-template');

    function formatCurrency(num) {
        return parseFloat(num || 0).toLocaleString('vi-VN');
    }

    function updateTotal() {
        let total = 0;
        rows.querySelectorAll('tr').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty')?.value) || 0;
            const price = parseFloat(row.querySelector('.price')?.value) || 0;
            const subtotal = qty * price;
            row.querySelector('.subtotal').textContent = formatCurrency(subtotal);
            total += subtotal;
        });
        totalEl.textContent = formatCurrency(total);
    }

    function addRow() {
        const html = template.innerHTML.replace(/__INDEX__/g, rowIndex);
        const wrapper = document.createElement('tbody');
        wrapper.innerHTML = html;
        const row = wrapper.firstElementChild;
        rows.appendChild(row);

        new TomSelect(row.querySelector('.book-select'), {
            create: false,
            placeholder: "Tìm sách...",
        });

        row.querySelectorAll('.qty, .price').forEach(input => {
            input.addEventListener('input', updateTotal);
        });

        rowIndex++;
        updateTotal();
    }

    document.getElementById('add-row').addEventListener('click', addRow);
    addRow(); // mặc định có 1 dòng
});
