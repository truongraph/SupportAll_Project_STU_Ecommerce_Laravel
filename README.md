B1: tải hoặc clone source về bỏ thư mục htdoct của xamp và chạy xamp

B2: tạo database tên toranowebsite với loại general utf8
- import databse vào

B3: Mở source bằng visual code

Tải file .env về và copy bỏ vô source

Mở terminal như đã hướng dẫn hoặc gõ Ctrl + shift + `

- Gõ lệnh composer update --with-all-dependencies

Đợi cho chạy hết optimize

Sau khi update lại composer xong thì chạy tiếp lệnh

php artisan key:generate

Xong thì chạy lệnh 

php artisan serve

thì sẽ ra ip: http://127.0.0.1:8000
