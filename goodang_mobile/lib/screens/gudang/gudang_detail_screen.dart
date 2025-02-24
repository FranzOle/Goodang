import 'package:flutter/material.dart';
import '../../services/gudang_service.dart';
import '../../models/gudang.dart';
import 'gudang_edit_screen.dart';

class GudangDetailScreen extends StatefulWidget {
  final int id;
  final bool isAdmin;
  const GudangDetailScreen({Key? key, required this.id, required this.isAdmin})
      : super(key: key);

  @override
  _GudangDetailScreenState createState() => _GudangDetailScreenState();
}

class _GudangDetailScreenState extends State<GudangDetailScreen> {
  bool isLoading = true;
  String message = '';
  Gudang? gudang;

  @override
  void initState() {
    super.initState();
    _fetchGudang();
  }

  Future<void> _fetchGudang() async {
    try {
      Gudang fetched = await GudangService.getGudang(widget.id, widget.isAdmin);
      setState(() {
        gudang = fetched;
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
        title: const Text('Detail Gudang'),
        actions: widget.isAdmin && gudang != null
            ? [
                IconButton(
                  icon: const Icon(Icons.edit),
                  onPressed: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) =>
                            GudangEditScreen(id: gudang!.id),
                      ),
                    ).then((_) => _fetchGudang());
                  },
                ),
              ]
            : null,
      ),
      body: isLoading
          ? const Center(child: CircularProgressIndicator())
          : gudang == null
              ? Center(child: Text(message))
              : Padding(
                  padding: const EdgeInsets.all(16.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text('ID: ${gudang!.id}',
                          style: const TextStyle(fontSize: 18)),
                      const SizedBox(height: 8),
                      Text('Nama: ${gudang!.nama}',
                          style: const TextStyle(fontSize: 18)),
                      const SizedBox(height: 8),
                      Text('Alamat: ${gudang!.alamat}',
                          style: const TextStyle(fontSize: 18)),
                    ],
                  ),
                ),
    );
  }
}
