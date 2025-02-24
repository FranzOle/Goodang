import 'package:flutter/material.dart';
import 'package:url_launcher/url_launcher.dart';
import '../../models/gudang.dart';
import '../../services/gudang_service.dart';
import '../../services/auth_service.dart';
import 'gudang_create_screen.dart';
import 'gudang_edit_screen.dart';
import 'gudang_detail_screen.dart';

class GudangListScreen extends StatefulWidget {
  const GudangListScreen({Key? key}) : super(key: key);

  @override
  _GudangListScreenState createState() => _GudangListScreenState();
}

class _GudangListScreenState extends State<GudangListScreen>
    with SingleTickerProviderStateMixin {
  bool isLoading = true;
  List<Gudang> _gudangList = [];
  String message = '';
  bool isAdmin = false;

  late AnimationController _animationController;
  late Animation<double> _fadeAnimation;

  @override
  void initState() {
    super.initState();
    _fetchUserAndGudang();
    _animationController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 600),
    );
    _fadeAnimation = CurvedAnimation(
      parent: _animationController,
      curve: Curves.easeIn,
    );
  }

  Future<void> _fetchUserAndGudang() async {
    try {
      final userResponse = await AuthService.getUser();
      if (userResponse['id'] != null) {
        String role = userResponse['role'] ?? 'user';
        setState(() {
          isAdmin = role == 'admin';
        });
      }
      List<Gudang> list = await GudangService.getAllGudang(isAdmin);
      setState(() {
        _gudangList = list;
        isLoading = false;
      });
      _animationController.forward(from: 0);
    } catch (e) {
      setState(() {
        message = e.toString();
        isLoading = false;
      });
    }
  }

  Future<void> _deleteGudang(int id) async {
    try {
      await GudangService.deleteGudang(id);
      _fetchUserAndGudang();
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Delete failed: $e')));
    }
  }

  Future<void> _launchExportPDF() async {
    final Uri url = Uri.parse('${AuthService.baseUrl}/gudang-export');
    if (await canLaunchUrl(url)) {
      await launchUrl(url, mode: LaunchMode.externalApplication);
    } else {
      ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Could not launch export URL')));
    }
  }

  Widget _buildGudangCard(Gudang gudang, int index) {
    return FadeTransition(
      opacity: _fadeAnimation,
      child: SlideTransition(
        position: Tween<Offset>(
          begin: const Offset(0, 0.1),
          end: Offset.zero,
        ).animate(_fadeAnimation),
        child: Card(
          margin: const EdgeInsets.symmetric(vertical: 8, horizontal: 4),
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12),
          ),
          elevation: 4,
          child: Padding(
            padding: const EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  gudang.nama,
                  style: const TextStyle(
                      fontSize: 18, fontWeight: FontWeight.w600),
                ),
                const SizedBox(height: 8),
                Text("Alamat: ${gudang.alamat}"),
                const SizedBox(height: 8),
                Row(
                  mainAxisAlignment: MainAxisAlignment.end,
                  children: [
                    IconButton(
                      icon:
                          const Icon(Icons.remove_red_eye, color: Colors.blue),
                      onPressed: () {
                        Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (context) => GudangDetailScreen(
                                id: gudang.id, isAdmin: isAdmin),
                          ),
                        ).then((_) => _fetchUserAndGudang());
                      },
                    ),
                    if (isAdmin) ...[
                      IconButton(
                        icon: const Icon(Icons.edit, color: Colors.green),
                        onPressed: () {
                          Navigator.push(
                            context,
                            MaterialPageRoute(
                              builder: (context) =>
                                  GudangEditScreen(id: gudang.id),
                            ),
                          ).then((_) => _fetchUserAndGudang());
                        },
                      ),
                      IconButton(
                        icon: const Icon(Icons.delete, color: Colors.red),
                        onPressed: () {
                          showDialog(
                            context: context,
                            builder: (context) => AlertDialog(
                              title: const Text('Confirm Delete'),
                              content: const Text(
                                  'Are you sure you want to delete this gudang?'),
                              actions: [
                                TextButton(
                                  onPressed: () =>
                                      Navigator.of(context).pop(),
                                  child: const Text('Cancel'),
                                ),
                                TextButton(
                                  onPressed: () {
                                    Navigator.of(context).pop();
                                    _deleteGudang(gudang.id);
                                  },
                                  child: const Text('Delete'),
                                ),
                              ],
                            ),
                          );
                        },
                      ),
                    ],
                  ],
                )
              ],
            ),
          ),
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Gudang'),
        actions: [
          IconButton(
            icon: const Icon(Icons.picture_as_pdf),
            onPressed: _launchExportPDF,
          )
        ],
      ),
      body: isLoading
          ? const Center(child: CircularProgressIndicator())
          : RefreshIndicator(
              onRefresh: _fetchUserAndGudang,
              child: SingleChildScrollView(
                physics: const AlwaysScrollableScrollPhysics(),
                padding: const EdgeInsets.all(16),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // Modern header with gradient
                    Container(
                      width: double.infinity,
                      padding: const EdgeInsets.all(16),
                      decoration: BoxDecoration(
                        gradient: LinearGradient(
                          colors: [
                            Colors.blue.shade300,
                            Colors.blue.shade600
                          ],
                          begin: Alignment.topLeft,
                          end: Alignment.bottomRight,
                        ),
                        borderRadius: BorderRadius.circular(12),
                      ),
                      child: const Text(
                        'List Gudang',
                        style: TextStyle(
                          color: Colors.white,
                          fontSize: 24,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                    ),
                    const SizedBox(height: 16),
                    // Action button(s)
                    if (isAdmin)
                      Align(
                        alignment: Alignment.centerRight,
                        child: ElevatedButton.icon(
                          onPressed: () {
                            Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (context) =>
                                    const GudangCreateScreen(),
                              ),
                            ).then((_) => _fetchUserAndGudang());
                          },
                          icon: const Icon(Icons.add),
                          label: const Text('Tambah Gudang'),
                          style: ElevatedButton.styleFrom(
                            backgroundColor: Colors.blue,
                            foregroundColor: Colors.white,
                            minimumSize: const Size(140, 45),
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(8),
                            ),
                          ),
                        ),
                      ),
                    const SizedBox(height: 16),
                    // List of gudang cards
                    ListView.builder(
                      shrinkWrap: true,
                      physics: const NeverScrollableScrollPhysics(),
                      itemCount: _gudangList.length,
                      itemBuilder: (context, index) {
                        final gudang = _gudangList[index];
                        return _buildGudangCard(gudang, index);
                      },
                    ),
                    if (message.isNotEmpty)
                      Padding(
                        padding: const EdgeInsets.only(top: 10),
                        child: Text(
                          message,
                          style: const TextStyle(color: Colors.red),
                        ),
                      ),
                  ],
                ),
              ),
            ),
    );
  }

  @override
  void dispose() {
    _animationController.dispose();
    super.dispose();
  }
}
