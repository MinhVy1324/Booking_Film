<?php
// File: TEMPLATES/admin_footer.php
?>

</div> <script>
    // --- LẤY RA CÁC MODAL ---
    const addMovieModal = document.getElementById('movieModal');
    const addRapModal = document.getElementById('rapModal');
    const addPhongModal = document.getElementById('phongModal');
    const addShowtimeModal = document.getElementById('showtimeModal');
    
    // NÂNG CẤP: Modal Sửa
    const editShowtimeModal = document.getElementById('editShowtimeModal');

    // Nút "Thêm Mới" chính
    const mainAddBtn = document.getElementById('addNewBtn');
    
    // Tất cả các nút đóng (dấu 'x')
    const allCloseBtns = document.querySelectorAll('.close-btn');

    // --- XỬ LÝ NÚT "THÊM MỚI" CHÍNH ---
    if (mainAddBtn) {
        mainAddBtn.onclick = function() {
            // Kiểm tra xem trang đang ở đâu và mở modal tương ứng
            if (addMovieModal) addMovieModal.style.display = 'flex';
            if (addRapModal) addRapModal.style.display = 'flex';
            if (addShowtimeModal) addShowtimeModal.style.display = 'flex';
        }
    }

    // --- XỬ LÝ NÚT "THÊM PHÒNG" (Trang rooms.php) ---
    const hiddenRapIdInput = document.getElementById('modal_rap_id');
    document.querySelectorAll('.add-room-btn').forEach(button => {
        button.onclick = function() {
            const rapId = this.getAttribute('data-rap-id');
            if (hiddenRapIdInput) hiddenRapIdInput.value = rapId;
            if (addPhongModal) addPhongModal.style.display = 'flex';
        }
    });

    // --- NÂNG CẤP: XỬ LÝ NÚT "SỬA" SUẤT CHIẾU ---
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Chặn link nhảy

            // 1. Lấy dữ liệu từ các thuộc tính data-* của nút được nhấn
            const id = this.getAttribute('data-id');
            const phimId = this.getAttribute('data-phim-id');
            const phongId = this.getAttribute('data-phong-id');
            const ngay = this.getAttribute('data-ngay');
            const gio = this.getAttribute('data-gio'); // Giờ đã có giây (HH:MM:SS)
            const gia = this.getAttribute('data-gia');

            // 2. Điền dữ liệu vào form trong modal SỬA
            // (Đảm bảo các ID này khớp với modal 'editShowtimeModal')
            document.getElementById('edit_suatchieu_id').value = id;
            document.getElementById('edit_phim').value = phimId;
            document.getElementById('edit_phong').value = phongId;
            document.getElementById('edit_ngayChieu').value = ngay;
            // Cắt bỏ giây (chỉ lấy HH:MM)
            document.getElementById('edit_gioBatDau').value = gio.substring(0, 5);
            document.getElementById('edit_giaVe').value = gia;
            
            // 3. Hiển thị modal SỬA
            if (editShowtimeModal) {
                editShowtimeModal.style.display = 'flex';
            }
        });
    });

    // --- XỬ LÝ ĐÓNG MODAL (Chung) ---
    // Đóng modal khi nhấn nút (x)
    allCloseBtns.forEach(btn => {
        btn.onclick = function() {
            btn.closest('.modal').style.display = 'none';
        }
    });

    // Đóng modal khi nhấn ra ngoài
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }
</script>

</body>
</html>