<?php
// File: TEMPLATES/admin_footer.php
?>

</div> <script>
    // --- 1. LẤY RA TẤT CẢ CÁC ĐỐI TƯỢNG CẦN THIẾT ---
    
    // Nút "Thêm Mới" chính (ở header)
    const mainAddBtn = document.getElementById('addNewBtn');
    
    // Tất cả các nút đóng (dấu 'x')
    const allCloseBtns = document.querySelectorAll('.close-btn');
    
    // Tất cả các Modal
    const allModals = document.querySelectorAll('.modal');
    
    // Modal Thêm Phim (Trang films.php)
    const movieModal = document.getElementById('movieModal');
    
    // Modal Thêm Rạp (Trang rooms.php)
    const rapModal = document.getElementById('rapModal');
    
    // Modal Thêm Phòng (Trang rooms.php)
    const phongModal = document.getElementById('phongModal');
    const hiddenRapIdInput = document.getElementById('modal_rap_id'); // Input ẩn trong form thêm phòng

    // Modal Thêm Suất Chiếu (Trang showtimes.php)
    const addShowtimeModal = document.getElementById('showtimeModal');
    
    // Modal Sửa Suất Chiếu (Trang showtimes.php)
    const editShowtimeModal = document.getElementById('editShowtimeModal');


    // --- 2. XỬ LÝ NÚT "THÊM MỚI" CHÍNH (addNewBtn) ---
    // Nút này sẽ mở modal "Thêm" tương ứng với trang hiện tại
    if (mainAddBtn) {
        mainAddBtn.onclick = function() {
            // Trang Quản Lý Phim
            if (movieModal) {
                // Reset form về trạng thái "Thêm Mới"
                document.getElementById('modalTitle').innerText = 'Thêm Phim Mới';
                document.getElementById('modalAction').value = 'add';
                document.getElementById('modalSubmitBtn').innerText = 'Lưu Lại';
                document.getElementById('movieForm').reset(); // Xóa trắng form
                document.getElementById('modalPhimId').value = ''; // Xóa ID (nếu có)
                movieModal.style.display = 'flex';
            }
            
            // Trang Quản Lý Rạp & Phòng
            if (rapModal) {
                rapModal.style.display = 'flex';
            }
            
            // Trang Quản Lý Suất Chiếu
            if (addShowtimeModal) {
                addShowtimeModal.style.display = 'flex';
            }
        }
    }

    // --- 3. XỬ LÝ CÁC NÚT "SỬA" (Nút .edit-btn) ---

    // 3.1. Xử lý nút "Sửa Phim" (Trang films.php)
    document.querySelectorAll('.edit-btn').forEach(button => {
        // Chỉ gán sự kiện nếu đây là trang films.php (có movieModal)
        if (movieModal) {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Chặn link

                // 1. Đổi tiêu đề và các input ẩn của Modal
                document.getElementById('modalTitle').innerText = 'Chỉnh Sửa Phim';
                document.getElementById('modalAction').value = 'edit';
                document.getElementById('modalSubmitBtn').innerText = 'Cập Nhật';
                
                // 2. Lấy dữ liệu từ data-* của nút Sửa
                const data = this.dataset;
                
                // 3. Điền dữ liệu vào form
                document.getElementById('modalPhimId').value = data.id;
                document.getElementById('tenPhim').value = data.ten;
                // (Đảm bảo các input trong form Sửa Phim có các ID này)
                document.getElementById('moTa').value = data.mota; 
                document.getElementById('ngayKhoiChieu').value = data.ngay;
                document.getElementById('thoiLuong').value = data.thoiluong;
                document.getElementById('posterUrl').value = data.poster;
                document.getElementById('theLoai').value = data.theloai;
                document.getElementById('xepHang').value = data.xephang;

                // 4. Mở modal
                movieModal.style.display = 'flex';
            });
        }
    });

    // 3.2. Xử lý nút "Sửa Suất Chiếu" (Trang showtimes.php)
    document.querySelectorAll('.edit-btn').forEach(button => {
        // Chỉ gán sự kiện nếu đây là trang showtimes.php (có editShowtimeModal)
        if (editShowtimeModal) {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Chặn link

                // 1. Lấy dữ liệu từ data-*
                const data = this.dataset;

                // 2. Điền dữ liệu vào form SỬA
                document.getElementById('edit_suatchieu_id').value = data.id;
                document.getElementById('edit_phim').value = data.phimId;
                document.getElementById('edit_phong').value = data.phongId;
                document.getElementById('edit_ngayChieu').value = data.ngay;
                document.getElementById('edit_gioBatDau').value = data.gio.substring(0, 5); // Cắt bỏ giây
                document.getElementById('edit_giaVe').value = data.gia;
                
                // 3. Hiển thị modal SỬA
                editShowtimeModal.style.display = 'flex';
            });
        }
    });


    // --- 4. XỬ LÝ CÁC NÚT ĐẶC BIỆT KHÁC ---

    // 4.1. Xử lý nút "Thêm Phòng" (Trang rooms.php)
    document.querySelectorAll('.add-room-btn').forEach(button => {
        button.onclick = function() {
            const rapId = this.getAttribute('data-rap-id');
            if (hiddenRapIdInput) hiddenRapIdInput.value = rapId;
            if (phongModal) phongModal.style.display = 'flex';
        }
    });

    
    // --- 5. XỬ LÝ ĐÓNG MODAL (Chung cho tất cả) ---

    // 5.1. Đóng modal khi nhấn nút (x)
    allCloseBtns.forEach(btn => {
        btn.onclick = function() {
            // Tìm modal cha gần nhất và đóng nó
            btn.closest('.modal').style.display = 'none';
        }
    });

    // 5.2. Đóng modal khi nhấn ra ngoài vùng màu đen
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }
</script>

</body> </html> ```