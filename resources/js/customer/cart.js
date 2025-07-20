document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('change', function () {
            const bookId = this.dataset.id;
            const quantity = this.value;
            
            fetch(`/cart/update-quantity/${bookId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ quantity })
            })

                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const row = document.querySelector(`tr[data-id="${bookId}"]`);
                        row.querySelector('.sub-total').textContent = data.sub_total;
                        document.getElementById('total-amount').textContent = data.total;
                    }
                });
        });
    });

    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function () {
            if (!confirm('Xác nhận xóa sản phẩm này?')) return;

            const bookId = this.dataset.id;

            fetch(`/cart/remove/${bookId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const row = document.querySelector(`tr[data-id="${bookId}"]`);
                        row.remove();
                        document.getElementById('total-amount').textContent = data.total;
                    }
                });
        });
    });
});
