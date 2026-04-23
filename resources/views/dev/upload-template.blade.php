<!-- This code is for temporary is only for development -->


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dev Tool - Upload Template</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; margin-bottom: 10px; }
        button { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .alert { padding: 10px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background-color: #d4edda; color: #155724; }
        .alert-error { background-color: #f8d7da; color: #721c24; }
        .note { font-size: 0.85em; color: #666; margin-top: 20px; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>

    <h2>🛠 Dev Tool: Upload Template MinIO</h2>

    @if(session('success'))
        <div class="alert alert-success">{!! session('success') !!}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <form action="{{ route('dev.template.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="target_name">Pilih Target Template (Sesuai Kodingan Service):</label>
            <select name="target_name" id="target_name" required>
                <option value="Template-email-asn.docx">Template-email-asn.docx (Untuk ASN)</option>
                <option value="Template-Email-Instansi.docx">Template-Email-Instansi.docx (Untuk Perangkat Daerah)</option>
                <option value="Template-Sub-Domain.docx">Template-Sub-Domain.docx (Untuk Perangkat Daerah)</option>
                <option value="Template-Pembuatan-sistem-awal.docx">Template-Pembuatan-sistem-awal.docx</option>
                <option value="Template-Pengembangan-fitur-apps.docx">Template-Pengembangan-fitur-apps.docx</option>
            </select>
        </div>

        <div class="form-group">
            <label for="template_file">Pilih File .docx (Yang sudah ada variabel ${...}):</label>
            <input type="file" name="template_file" id="template_file" accept=".docx" required>
        </div>

        <button type="submit">Upload ke MinIO 🚀</button>
    </form>

    <div class="note">
        <strong>Catatan:</strong> 
        <br>1. Pastikan file Word sudah ditutup sebelum diupload.
        <br>2. Halaman ini hanya untuk Development. Hapus route-nya saat Production.
    </div>

</body>
</html>