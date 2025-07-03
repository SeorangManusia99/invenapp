<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2 style="text-align: center; text-decoration: underline">Laporan Data Barang</h2>

<table>
  <tr>
    <th>No</th>
    <th>Nama Barang</th>
    <th>Merk</th>
    <th>Tipe</th>
    <th>Satuan</th>
  </tr>
  @foreach ($barang as $brg)
  <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $brg->nama_barang }}</td>
    <td>{{ $brg->merk }}</td>
    <td>{{ $brg->tipe }}</td>
    <td>{{ $brg->satuan }}</td>
  </tr>
  @endforeach

</table>

<div style="width: 100%; margin-top: 50px;">
    <div style="float: right; text-align: center;">
        <p>Mengetahui,</p>
        <br>
        <br>
        <br>
        <p>(___________________)</p>
    </div>
</div>

</body>
</html>
