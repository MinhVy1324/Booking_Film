<?php
// File: templates/admin_footer.php
?>

</div> <script>
    const modal = document.getElementById('movieModal');
    const addBtn = document.getElementById('addNewBtn');
    const closeBtn = document.getElementById('closeBtn');

    // (Kiểm tra xem các nút có tồn tại không trước khi gán sự kiện)
    if (addBtn) {
        addBtn.onclick = function() {
            modal.style.display = 'flex';
        }
    }
    if (closeBtn) {
        closeBtn.onclick = function() {
            modal.style.display = 'none';
        }
    }
    // Đóng khi nhấn ra ngoài modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>

</body>
</html>