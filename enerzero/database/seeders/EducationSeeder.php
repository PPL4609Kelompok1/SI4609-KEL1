<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EducationSeeder extends Seeder
{
    public function run(): void
    {
        $educations = [
            [
                'title' => 'Tips Hemat Listrik di Rumah',
                'content' => '
                    <h2>Menghemat Listrik: Mulai dari Rumah Anda</h2>
                    <p>Menghemat listrik bukan hanya soal mengurangi tagihan bulanan, tapi juga kontribusi nyata untuk lingkungan. Setiap kilowatt-jam yang kita hemat berarti mengurangi beban pembangkit listrik yang sebagian besar masih menggunakan bahan bakar fosil.</p>

                    <h3>Cara Mudah Hemat Listrik Sehari-hari:</h3>
                    <ul>
                        <li><strong>Ganti Lampu Lama dengan LED:</strong> Lampu LED mengonsumsi energi hingga 80% lebih sedikit dan tahan lebih lama dibandingkan lampu pijar atau neon.</li>
                        <li><strong>Cabut Kabel Saat Tidak Digunakan:</strong> Peralatan elektronik seperti TV, charger, atau komputer tetap menarik daya (phantom load) meskipun dalam mode standby. Cabut kabelnya untuk menghemat energi.</li>
                        <li><strong>Optimalkan Penggunaan AC:</strong> Atur suhu AC pada tingkat yang nyaman dan sehat, idealnya 24-26°C. Bersihkan filter AC secara rutin agar kinerjanya optimal dan tidak boros energi.</li>
                        <li><strong>Bijak Menggunakan Mesin Cuci:</strong> Selalu cuci pakaian sesuai kapasitas mesin. Gunakan air dingin jika memungkinkan, karena sebagian besar energi mesin cuci digunakan untuk memanaskan air.</li>
                        <li><strong>Pilih Peralatan Berlabel Hemat Energi:</strong> Saat membeli peralatan baru, cari label efisiensi energi. Produk dengan label ini biasanya lebih mahal di awal, tapi akan menghemat biaya listrik dalam jangka panjang.</li>
                        <li><strong>Manfaatkan Pencahayaan Alami:</strong> Buka tirai dan biarkan cahaya matahari masuk di siang hari. Ini mengurangi kebutuhan akan lampu listrik.</li>
                    </ul>

                    <p>Langkah-langkah kecil ini, jika dilakukan secara konsisten, dapat memberikan dampak besar pada penghematan energi di rumah Anda.</p>
                ',
                'category' => 'Rumah Tangga',
                'image_url' => 'https://images.unsplash.com/photo-1558002038-1055907df827?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            ],
            [
                'title' => 'Mengenal Energi Terbarukan',
                'content' => '
                    <h2>Energi Terbarukan: Masa Depan Energi Dunia</h2>
                    <p>Di tengah isu perubahan iklim dan keterbatasan sumber daya fosil, energi terbarukan hadir sebagai solusi energi yang berkelanjutan dan ramah lingkungan. Sumber energi ini berasal dari proses alam yang terus berkelanjutan.</p>

                    <h3>Jenis-jenis Energi Terbarukan Utama:</h3>
                    <ul>
                        <li><strong>Energi Matahari (Solar):</strong> Mengubah cahaya matahari menjadi listrik menggunakan panel surya. Potensinya sangat besar, terutama di negara tropis seperti Indonesia.</li>
                        <li><strong>Energi Angin:</strong> Memanfaatkan tenaga angin untuk memutar turbin dan menghasilkan listrik.</li>
                        <li><strong>Energi Air (Hydro):</strong> Menggunakan energi kinetik air yang mengalir atau jatuh (PLTA) untuk memutar turbin.</li>
                        <li><strong>Energi Biomassa:</strong> Memanfaatkan bahan organik seperti sisa tanaman, limbah pertanian, atau kotoran hewan untuk menghasilkan energi (listrik atau panas).</li>
                        <li><strong>Energi Panas Bumi (Geothermal):</strong> Menggunakan panas dari dalam bumi untuk menghasilkan listrik atau pemanas.</li>
                    </ul>

                    <p>Investasi dan pengembangan energi terbarukan krusial untuk mencapai kemandirian energi dan menjaga kelestarian planet kita.</p>
                ',
                'category' => 'Energi Terbarukan',
                'image_url' => 'https://images.unsplash.com/photo-1509391366360-2e959784a276?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            ],
            [
                'title' => 'Transportasi Ramah Lingkungan: Bergerak Tanpa Merusak Bumi',
                'content' => '
                    <h2>Transportasi Hijau: Pilihan Sadar Lingkungan</h2>
                    <p>Sektor transportasi merupakan salah satu kontributor utama emisi gas rumah kaca. Beralih ke moda transportasi yang lebih ramah lingkungan adalah langkah penting untuk mengurangi jejak karbon pribadi.</p>

                    <h3>Alternatif Transportasi Ramah Lingkungan:</h3>
                    <ul>
                        <li><strong>Kendaraan Listrik (EV):</strong> Menggunakan listrik sebagai sumber tenaga utama, menghasilkan emisi nol di titik penggunaan.</li>
                        <li><strong>Transportasi Umum:</strong> Kereta, bus, dan KRL mengangkut banyak orang sekaligus, jauh lebih efisien energi per penumpang dibandingkan mobil pribadi.</li>
                        <li><strong>Bersepeda:</strong> Selain sehat, bersepeda tidak menghasilkan emisi sama sekali. Cocok untuk jarak dekat dan menengah.</li>
                        <li><strong>Berjalan Kaki:</strong> Pilihan paling ramah lingkungan dan sehat untuk jarak sangat dekat.</li>
                        <li><strong>Carpooling:</strong> Berbagi tumpangan dengan rekan kerja atau teman mengurangi jumlah mobil di jalan dan emisi per orang.</li>
                        <li><strong>Perawatan Kendaraan Rutin:</strong> Kendaraan yang terawat dengan baik lebih efisien dalam penggunaan bahan bakar.</li>
                    </ul>

                    <p>Setiap kali Anda memilih opsi transportasi yang lebih hijau, Anda turut berkontribusi pada kualitas udara yang lebih baik dan planet yang lebih sehat.</p>
                ',
                'category' => 'Transportasi',
                'image_url' => 'https://images.unsplash.com/photo-1558981806-ec527fa84c39?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            ],
            [
                'title' => 'Efisiensi Energi di Tempat Kerja: Kantor yang Lebih Hijau',
                'content' => '
                    <h2>Hemat Energi di Kantor: Produktif dan Ramah Lingkungan</h2>
                    <p>Menciptakan lingkungan kerja yang efisien energi tidak hanya mengurangi biaya operasional perusahaan, tetapi juga meningkatkan kesadaran lingkungan di antara karyawan.</p>

                    <h3>Strategi Efisiensi Energi di Kantor:</h3>
                    <ul>
                        <li><strong>Budaya Matikan Perangkat:</strong> Sosialisakan kebiasaan mematikan komputer, lampu, dan peralatan elektronik lainnya saat tidak digunakan, terutama di akhir hari kerja.</li>
                        <li><strong>Optimalkan Pencahayaan:</strong> Manfaatkan cahaya matahari semaksimal mungkin dengan menata ulang tata letak ruang kerja. Gunakan lampu LED dan pertimbangkan sensor gerak di area yang jarang digunakan.</li>
                        <li><strong>Pengaturan Suhu yang Tepat:</strong> Sesuaikan suhu termostat secara moderat. Hindari pendinginan atau pemanasan berlebihan. Pastikan jendela dan pintu tertutup saat AC atau pemanas menyala.</li>
                        <li><strong>Pilih Peralatan Kantor Hemat Energi:</strong> Saat membeli peralatan baru seperti printer, monitor, atau mesin kopi, pilih model yang memiliki sertifikasi hemat energi.</li>
                        <li><strong>Program Daur Ulang dan Paperless:</strong> Kurangi penggunaan kertas dengan memaksimalkan komunikasi digital. Program daur ulang yang efektif juga berkontribusi pada efisiensi sumber daya secara keseluruhan.</li>
                        <li><strong>Audit Energi Berkala:</strong> Lakukan audit energi untuk mengidentifikasi area di mana energi paling banyak terbuang dan temukan peluang perbaikan.</li>
                    </ul>

                    <p>Kantor yang efisien energi menciptakan lingkungan yang lebih nyaman, sehat, dan berkelanjutan bagi semua orang.</p>
                ',
                'category' => 'Tempat Kerja',
                'image_url' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            ],
            [
                'title' => 'Teknologi Smart Home: Otomatisasi untuk Hemat Energi',
                'content' => '
                    <h2>Smart Home: Rumah Pintar, Hemat Energi</h2>
                    <p>Teknologi smart home menawarkan cara inovatif untuk mengelola dan mengoptimalkan penggunaan energi di rumah. Dengan perangkat yang saling terhubung, Anda bisa memiliki kontrol lebih besar atas konsumsi energi Anda.</p>

                    <h3>Perangkat Smart Home untuk Efisiensi Energi:</h3>
                    <ul>
                        <li><strong>Smart Thermostat:</strong> Belajar kebiasaan Anda dan secara otomatis menyesuaikan suhu untuk efisiensi maksimal saat Anda pergi atau tidur. Dapat dikontrol dari jarak jauh melalui smartphone.</li>
                        <li><strong>Smart Lighting System:</strong> Mengontrol lampu dari jarak jauh, mengatur jadwal, dan bahkan menyesuaikan kecerahan berdasarkan cahaya alami.</li>
                        <li><strong>Smart Power Strips:</strong> Memutus daya ke perangkat yang tidak digunakan atau dalam mode standby untuk mencegah phantom load.</li>
                        <li><strong>Smart Appliances:</strong> Peralatan rumah tangga modern seringkali dilengkapi fitur hemat energi dan dapat diatur dari jarak jauh.</li>
                        <li><strong>Energy Monitoring Systems:</strong> Memantau penggunaan energi seluruh rumah atau perangkat individu secara real-time, membantu Anda mengidentifikasi area pemborosan.</li>
                    </ul>

                    <p>Integrasi teknologi smart home tidak hanya memberikan kenyamanan tetapi juga merupakan investasi cerdas untuk masa depan energi yang lebih hemat.</p>
                ',
                'category' => 'Teknologi',
                'image_url' => 'https://images.unsplash.com/photo-1558002038-1055907df827?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            ],
        ];

        foreach ($educations as $education) {
            Education::create([
                'title' => $education['title'],
                'content' => $education['content'],
                'category' => $education['category'],
                'image_url' => $education['image_url'],
                'slug' => Str::slug($education['title']),
            ]);
        }
    }
} 