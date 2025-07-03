namespace App\Export;

use App\Models\Barang;
use iluminate\contracts\View\View;
use maatwebsite\excel\Concerns\FromView;

cllass BarangExport implements FromView
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $barangs = Barang::all();
        return view('barang.laporan-barang', [
            'barangs' => $barangs,:all()
            'drawing' => $drawing, // Pastikan $drawing didefinisikan sebelumnya
        ]);
    }
}

$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
$drawing->setName('Logo');
$drawing->setDescription('This is my logo');
$drawing->setPath(public_path('/img/logo.jpg'));
$drawing->setHeight(90);