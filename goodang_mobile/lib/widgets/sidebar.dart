import 'package:flutter/material.dart';

class Sidebar extends StatelessWidget {
  final String userName;
  final String userEmail;

  const Sidebar({
    Key? key,
    required this.userName,
    required this.userEmail,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Drawer(
      child: ListView(
        padding: EdgeInsets.zero,
        children: [
          // Header Brand
          DrawerHeader(
            decoration: BoxDecoration(
              color: Colors.white,
              border: Border(
                bottom: BorderSide(color: Colors.grey.shade300),
              ),
            ),
            child: Center(
              child: Text(
                'Goodang',
                style: TextStyle(
                  fontSize: 28,
                  fontWeight: FontWeight.bold,
                  color: Colors.blue,
                ),
              ),
            ),
          ),
          // User Panel
          ListTile(
            leading: Icon(Icons.person),
            title: Text(userName, style: TextStyle(fontWeight: FontWeight.bold)),
            subtitle: Text(userEmail),
          ),
          Divider(),
          // Master Menu
          ExpansionTile(
            leading: Icon(Icons.dashboard),
            title: Text('Master'),
            children: [
              ListTile(
                leading: Icon(Icons.person_outline),
                title: Text('Data User'),
                onTap: () {},
              ),
              ListTile(
                leading: Icon(Icons.category),
                title: Text('Kategori Barang'),
                onTap: () {},
              ),
              ListTile(
                leading: Icon(Icons.local_shipping),
                title: Text('Supplier Barang'),
                onTap: () {},
              ),
              ListTile(
                leading: Icon(Icons.warehouse),
                title: Text('Data Gudang'),
                onTap: () {},
              ),
              ListTile(
                leading: Icon(Icons.inventory),
                title: Text('Data Barang'),
                onTap: () {},
              ),
            ],
          ),
          // Transaksi Menu
          ExpansionTile(
            leading: Icon(Icons.swap_horiz),
            title: Text('Transaksi'),
            children: [
              ListTile(
                leading: Icon(Icons.add_shopping_cart),
                title: Text('Transaksi Masuk'),
                onTap: () {},
              ),
              ListTile(
                leading: Icon(Icons.remove_shopping_cart),
                title: Text('Transaksi Keluar'),
                onTap: () {},
              ),
              ListTile(
                leading: Icon(Icons.compare_arrows),
                title: Text('Transaksi Gudang'),
                onTap: () {},
              ),
              ListTile(
                leading: Icon(Icons.history),
                title: Text('Log History'),
                onTap: () {},
              ),
              ListTile(
                leading: Icon(Icons.receipt),
                title: Text('Kartu Stok'),
                onTap: () {},
              ),
            ],
          ),
          // Penjualan Menu
          ExpansionTile(
            leading: Icon(Icons.point_of_sale),
            title: Text('Penjualan'),
            children: [
              ListTile(
                leading: Icon(Icons.pie_chart),
                title: Text('Dashboard Penjualan'),
                onTap: () {},
              ),
              ListTile(
                leading: Icon(Icons.insert_chart),
                title: Text('Laporan Penjualan'),
                onTap: () {},
              ),
              ListTile(
                leading: Icon(Icons.handshake),
                title: Text('Transaksi Langsung'),
                onTap: () {},
              ),
              ListTile(
                leading: Icon(Icons.group),
                title: Text('Manajemen Klien'),
                onTap: () {},
              ),
              ListTile(
                leading: Icon(Icons.people),
                title: Text('Tim Sales'),
                onTap: () {},
              ),
            ],
          ),
        ],
      ),
    );
  }
}
