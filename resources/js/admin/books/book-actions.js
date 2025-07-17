// Xử lý xóa sách
function submitDelete(url, isDiscounted) {
    if (isDiscounted) {
        alert('Không thể xóa sách đang được áp dụng khuyến mãi!');
        return;
    }

    if (confirm('Bạn có chắc chắn muốn xóa sách này?')) {
        const form = document.getElementById('delete-form');
        form.action = url;
        form.submit();
    }
}


// Gắn các hàm ra global để gọi từ HTML
window.submitDelete = submitDelete;
