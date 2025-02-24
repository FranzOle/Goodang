import 'package:flutter/material.dart';
import '../../services/kategori_service.dart';
import '../../models/kategori.dart';
import 'kategori_edit_screen.dart';

class KategoriDetailScreen extends StatefulWidget {
  final int id;
  final bool isAdmin;
  const KategoriDetailScreen({Key? key, required this.id, required this.isAdmin})
      : super(key: key);

  @override
  _KategoriDetailScreenState createState() => _KategoriDetailScreenState();
}

class _KategoriDetailScreenState extends State<KategoriDetailScreen> {
  bool isLoading = true;
  String message = '';
  Kategori? kategori;

  @override
  void initState() {
    super.initState();
    _fetchKategori();
  }

  Future<void> _fetchKategori() async {
    try {
      Kategori fetched =
          await KategoriService.getKategori(widget.id, widget.isAdmin);
      setState(() {
        kategori = fetched;
        isLoading = false;
      });
    } catch (e) {
      setState(() {
        message = e.toString();
        isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Detail Kategori'),
        actions: widget.isAdmin && kategori != null
            ? [
                IconButton(
                  icon: const Icon(Icons.edit),
                  onPressed: () {
                    Navigator.push(
                        context,
                        MaterialPageRoute(
                            builder: (context) =>
                                KategoriEditScreen(id: kategori!.id))).then((_) {
                      _fetchKategori();
                    });
                  },
                ),
              ]
            : null,
      ),
      body: isLoading
          ? const Center(child: CircularProgressIndicator())
          : kategori == null
              ? Center(child: Text(message))
              : Padding(
                  padding: const EdgeInsets.all(16.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text('ID: ${kategori!.id}',
                          style: const TextStyle(fontSize: 18)),
                      const SizedBox(height: 8),
                      Text('Nama: ${kategori!.nama}',
                          style: const TextStyle(fontSize: 18)),
                    ],
                  ),
                ),
    );
  }
}
