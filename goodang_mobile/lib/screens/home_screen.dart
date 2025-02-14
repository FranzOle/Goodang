import 'package:flutter/material.dart';
import '../service/auth_service.dart';
import '../models/user.dart';
import '../widgets/sidebar.dart';

class HomeScreen extends StatefulWidget {
  @override
  _HomeScreenState createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  bool isLoading = false;
  String message = '';

  User? _user;
  bool _isUserLoading = true;

  @override
  void initState() {
    super.initState();
    _fetchLoggedUser();
  }

  Future<void> _fetchLoggedUser() async {
    final userResponse = await AuthService.getUser();
    // Assuming the API returns the user data directly (e.g., { "id": 1, "name": "John Doe", "email": "john@example.com" })
    if (userResponse != null && userResponse['id'] != null) {
      setState(() {
        _user = User.fromJson(userResponse);
        _isUserLoading = false;
      });
    } else {
      setState(() {
        _isUserLoading = false;
        message = userResponse['message'] ?? 'Failed to load user data.';
      });
    }
  }

  Future<void> _handleLogout() async {
    setState(() {
      isLoading = true;
      message = '';
    });
    final response = await AuthService.logout();
    setState(() {
      isLoading = false;
    });
    if (response['success'] == true) {
      Navigator.pushReplacementNamed(context, '/');
    } else {
      setState(() {
        message = response['message'] ?? 'Logout failed. Please try again.';
      });
    }
  }

  Widget _buildDashboardContent() {
    return SingleChildScrollView(
      padding: EdgeInsets.all(16),
      child: _user == null
          ? Center(child: Text('No user data'))
          : Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Dashboard header
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Text(
                      'Halo, ${_user!.name}',
                      style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
                    ),
                    Text(
                      'Dashboard',
                      style: TextStyle(fontSize: 16, color: Colors.grey),
                    ),
                  ],
                ),
                SizedBox(height: 20),
                // Info Boxes
                Row(
                  children: [
                    _buildInfoBox('Jumlah Gudang', '5', Icons.warehouse),
                    SizedBox(width: 10),
                    _buildInfoBox('Jumlah Barang', '50', Icons.inventory),
                  ],
                ),
                SizedBox(height: 10),
                Row(
                  children: [
                    _buildInfoBox('Transaksi Bulan Ini', '10', Icons.shopping_cart),
                    SizedBox(width: 10),
                    _buildInfoBox('Jumlah User', '3', Icons.people),
                  ],
                ),
                SizedBox(height: 20),
                // Row: Stock Movement & Transaksi 7 Hari Terakhir
                Row(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Expanded(
                      child: _buildCard(
                        title: 'Stock Movement',
                        child: Container(
                          height: 200,
                          color: Colors.blue.shade50,
                          child: Center(child: Text('Chart Placeholder')),
                        ),
                      ),
                    ),
                    SizedBox(width: 10),
                    Expanded(
                      child: _buildCard(
                        title: 'Transaksi Dalam 7 Hari Terakhir',
                        child: Container(
                          height: 200,
                          child: Column(
                            children: [
                              Text(
                                'Total Transaksi: 5',
                                style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                              ),
                              Expanded(
                                child: ListView(
                                  children: List.generate(5, (index) {
                                    return ListTile(
                                      dense: true,
                                      title: Text('Kode Ref ${index + 1}'),
                                      subtitle: Text('Tanggal: 2025-02-14'),
                                    );
                                  }),
                                ),
                              ),
                            ],
                          ),
                        ),
                      ),
                    ),
                  ],
                ),
                SizedBox(height: 20),
                // Row: Stok Barang Sedikit & 5 Staff Paling Aktif
                Row(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Expanded(
                      flex: 2,
                      child: _buildCard(
                        title: 'Stok Barang Sedikit',
                        child: Container(
                          height: 200,
                          child: DataTable(
                            columns: [
                              DataColumn(label: Text('Barang')),
                              DataColumn(label: Text('Gudang')),
                              DataColumn(label: Text('Kuantitas')),
                              DataColumn(label: Text('Aksi')),
                            ],
                            rows: List.generate(3, (index) {
                              return DataRow(cells: [
                                DataCell(Text('Barang ${index + 1}')),
                                DataCell(Text('Gudang ${index + 1}')),
                                DataCell(Text('${5 - index}')),
                                DataCell(Icon(Icons.search)),
                              ]);
                            }),
                          ),
                        ),
                      ),
                    ),
                    SizedBox(width: 10),
                    Expanded(
                      flex: 1,
                      child: _buildCard(
                        title: '5 Staff Paling Aktif',
                        child: Container(
                          height: 200,
                          child: DataTable(
                            columns: [
                              DataColumn(label: Text('Username')),
                              DataColumn(label: Text('Total Transaksi')),
                            ],
                            rows: List.generate(5, (index) {
                              return DataRow(cells: [
                                DataCell(Text('Staff ${index + 1}')),
                                DataCell(Text('${10 - index}')),
                              ]);
                            }),
                          ),
                        ),
                      ),
                    ),
                  ],
                ),
                if (message.isNotEmpty)
                  Padding(
                    padding: EdgeInsets.only(top: 10),
                    child: Center(
                      child: Text(
                        message,
                        style: TextStyle(color: Colors.red),
                      ),
                    ),
                  ),
              ],
            ),
    );
  }

  Widget _buildInfoBox(String title, String count, IconData icon) {
    return Expanded(
      child: Card(
        elevation: 2,
        child: Container(
          padding: EdgeInsets.all(12),
          child: Row(
            children: [
              Container(
                padding: EdgeInsets.all(8),
                decoration: BoxDecoration(
                  color: Colors.blue,
                  borderRadius: BorderRadius.circular(4),
                ),
                child: Icon(icon, color: Colors.white),
              ),
              SizedBox(width: 10),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(title, style: TextStyle(fontWeight: FontWeight.bold)),
                    Text(count, style: TextStyle(fontSize: 16)),
                  ],
                ),
              )
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildCard({required String title, required Widget child}) {
    return Card(
      elevation: 2,
      child: Container(
        padding: EdgeInsets.all(12),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(title,
                style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
            Divider(),
            child,
          ],
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return _isUserLoading
        ? Scaffold(
            appBar: AppBar(
              title: Text('Dashboard'),
            ),
            body: Center(child: CircularProgressIndicator()),
          )
        : Scaffold(
            appBar: AppBar(
              title: Text('Dashboard'),
              actions: [
                IconButton(
                  icon: Icon(Icons.logout),
                  onPressed: _handleLogout,
                ),
              ],
            ),
            drawer: Sidebar(
              userName: _user?.name ?? '',
              userEmail: _user?.email ?? '',
            ),
            body: _buildDashboardContent(),
          );
  }
}
