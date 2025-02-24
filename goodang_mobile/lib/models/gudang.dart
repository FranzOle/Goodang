class Gudang {
  final int id;
  final String nama;
  final String alamat;

  Gudang({
    required this.id,
    required this.nama,
    required this.alamat,
  });

  factory Gudang.fromJson(Map<String, dynamic> json) {
    return Gudang(
      id: json['id'] ?? 0,
      nama: json['nama'] ?? '',
      alamat: json['alamat'] ?? '',
    );
  }
}
