class Supplier {
  final int id;
  final String nama;
  final String telepon;
  final String alamat;

  Supplier({
    required this.id,
    required this.nama,
    required this.telepon,
    required this.alamat,
  });

  factory Supplier.fromJson(Map<String, dynamic> json) {
    return Supplier(
      id: json['id'] ?? 0,
      nama: json['nama'] ?? '',
      telepon: json['telepon'] ?? '',
      alamat: json['alamat'] ?? '',
    );
  }
}
