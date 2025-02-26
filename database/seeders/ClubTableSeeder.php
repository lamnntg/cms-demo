<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClubTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    static public function run()
    {
        $data = [
            [
                'name' => 'FAHAM SHISHA LOUNGE',
                'description' => 'Là viên than nồng đốt lên những cuộc vui đáng nhớ, Faham xuất hiện để truyền lửa cho thế hệ mới của “Sài Gòn Nightlife”. Tìm đến Faham tại địa điểm vàng: Số 20, Nguyễn Công Trứ, thành phố Hồ Chí Minh để cùng chúng tôi tận hưởng những đêm nhiệt huyết và thú vị nhất của tuổi trẻ “một lần”.',
                'type' => 'Premium',
                'logo' => 'http://www.google.com/logo.png',
                'operating_hours' => '6PM - LATE',
                'address' => '153 Tôn Thất Đạm, P. Bến Nghé, Quận 1, TPHCM',
                'phone' => '090.976.6969',
                'email' => 'faham_shisha_lounge@gmail.com',
            ],
            [
                'name' => 'KASHO CLUB',
                'description' => 'Nằm toạ lạc ngay tại khu vực trung tâm Sài Gòn, chúng tôi định hướng cho mình theo phong cách thời thượng Nhật Bản',
                'type' => 'Premium',
                'logo' => 'http://www.google.com/logo.png',
                'operating_hours' => '10:00pm - 3:00am',
                'address' => '99 Nguyễn Thị Minh Khai, Bến Thành, Quận 1, TPHCM',
                'phone' => '097.750.2502',
                'email' => 'kasho_club@gmail.com',
            ],
            [
                'name' => 'THE BUNKER',
                'description' => 'Đến với The Bunker, bạn sẽ được rũ bỏ "vỏ bọc" ngày thường, được tự do khoác lên những bộ trang phục thoải mái...',
                'type' => 'Premium',
                'logo' => 'http://www.google.com/logo.png',
                'operating_hours' => '9:00pm - 3:00am',
                'address' => '46 Phố Mã Mây, Hàng Buồm, Hoàn Kiếm, Hà Nội',
                'phone' => '090.976.6969',
                'email' => 'bunker@gmail.com',
            ],
            [
                'name' => 'SNIFF',
                'description' => 'SNIFF không chỉ là một Premium Bar mà còn là những thể nghiệm sáng tạo về không gian, âm nhạc, concept nghệ thuật và khả năng ‘tương tác’.',
                'type' => 'Premium',
                'logo' => 'http://www.google.com/logo.png',
                'operating_hours' => '9:00pm - 3:00am',
                'address' => '46 Phố Mã Mây, Hàng Buồm, Hoàn Kiếm, Hà Nội',
                'phone' => '093.155.3555',
                'email' => 'sniff@gmail.com',
            ],
            [
                'name' => 'JIGGER DOWNTOWN',
                'description' => 'Với không gian và đồ uống mang đậm chất Á Đông, chúng tôi mong muốn sẽ cùng các bạn xây dựng lên 1 đế chế tôn vinh sự sáng tạo bất tận của người khổng lồ Châu Á trong giới thưởng thức cocktail.',
                'type' => 'Premium',
                'logo' => 'http://www.google.com/logo.png',
                'operating_hours' => '6:30pm - 2:00am',
                'address' => '46 Phố Mã Mây, Hàng Buồm, Hoàn Kiếm, Hà Nội',
                'phone' => '091.777.7420',
                'email' => 'igger_downtown@gmail.com',
            ],
        ];

        DB::table('clubs')->insert($data);
    }
}
