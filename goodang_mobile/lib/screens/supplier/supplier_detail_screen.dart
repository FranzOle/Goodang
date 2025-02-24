import 'package:flutter/material.dart';
import '../../services/supplier_service.dart';
import '../../models/supplier.dart';
import 'supplier_edit_screen.dart';

class SupplierDetailScreen extends StatefulWidget {
  final int id;
  final bool isAdmin;
  const SupplierDetailScreen({Key? key, required this.id, required this.isAdmin})
      : super(key: key);

  @override
  _SupplierDetailScreenState createState() => _SupplierDetailScreenState();
}

class _SupplierDetailScreenState extends State<SupplierDetailScreen> {
  bool isLoading = true;
  String message = '';
  Supplier? supplier;

  @override
  void initState() {
    super.initState();
    _fetchSupplier();
  }

  Future<void> _fetchSupplier() async {
    try {
      Supplier fetched = await SupplierService.getSupplier(widget.id, widget.isAdmin);
      setState(() {
        supplier = fetched;
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
        title: const Text('Detail Supplier'),
        actions: widget.isAdmin && supplier != null
            ? [
                IconButton(
                  icon: const Icon(Icons.edit),
                  onPressed: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => SupplierEditScreen(id: supplier!.id),
                      ),
                    ).then((_) => _fetchSupplier());
                  },
                ),
              ]
            : null,
      ),
      body: isLoading
          ? const Center(child: CircularProgressIndicator())
          : supplier == null
              ? Center(child: Text(message))
              : Padding(
                  padding: const EdgeInsets.all(16.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text('ID: ${supplier!.id}', style: const TextStyle(fontSize: 18)),
                      const SizedBox(height: 8),
                      Text('Nama: ${supplier!.nama}', style: const TextStyle(fontSize: 18)),
                      const SizedBox(height: 8),
                      Text('Telepon: ${supplier!.telepon}', style: const TextStyle(fontSize: 18)),
                      const SizedBox(height: 8),
                      Text('Alamat: ${supplier!.alamat}', style: const TextStyle(fontSize: 18)),
                    ],
                  ),
                ),
    );
  }
}
