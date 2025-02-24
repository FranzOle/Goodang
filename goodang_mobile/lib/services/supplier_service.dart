import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import '../models/supplier.dart';
import 'auth_service.dart';

class SupplierService {
  static const String baseUrl = AuthService.baseUrl;

  // Fetch all suppliers (admin vs. non-admin)
  static Future<List<Supplier>> getAllSuppliers(bool isAdmin) async {
    final endpoint =
        isAdmin ? '$baseUrl/supplier' : '$baseUrl/staffsupplier';
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString('token');
    final response = await http.get(Uri.parse(endpoint), headers: {
      'Authorization': 'Bearer $token',
    });
    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      List<dynamic> list = data['data'];
      return list.map((json) => Supplier.fromJson(json)).toList();
    } else {
      throw Exception('Failed to load suppliers');
    }
  }

  static Future<Supplier> getSupplier(int id, bool isAdmin) async {
    final endpoint =
        isAdmin ? '$baseUrl/supplier/$id' : '$baseUrl/staffsupplier/$id';
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString('token');
    final response = await http.get(Uri.parse(endpoint), headers: {
      'Authorization': 'Bearer $token',
    });
    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      return Supplier.fromJson(data['data']);
    } else {
      throw Exception('Failed to load supplier');
    }
  }

  static Future<Supplier> createSupplier(String nama, String telepon, String alamat) async {
    final endpoint = '$baseUrl/supplier';
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString('token');
    final response = await http.post(Uri.parse(endpoint), headers: {
      'Authorization': 'Bearer $token',
    }, body: {
      'nama': nama,
      'telepon': telepon,
      'alamat': alamat,
    });
    if (response.statusCode == 201) {
      final data = jsonDecode(response.body);
      return Supplier.fromJson(data['data']);
    } else {
      throw Exception('Failed to create supplier');
    }
  }

  static Future<Supplier> updateSupplier(int id, String nama, String telepon, String alamat) async {
    final endpoint = '$baseUrl/supplier/$id';
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString('token');
    final response = await http.put(Uri.parse(endpoint), headers: {
      'Authorization': 'Bearer $token',
    }, body: {
      'nama': nama,
      'telepon': telepon,
      'alamat': alamat,
    });
    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      return Supplier.fromJson(data['data']);
    } else {
      throw Exception('Failed to update supplier');
    }
  }

  static Future<void> deleteSupplier(int id) async {
    final endpoint = '$baseUrl/supplier/$id';
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString('token');
    final response = await http.delete(Uri.parse(endpoint), headers: {
      'Authorization': 'Bearer $token',
    });
    if (response.statusCode != 200) {
      throw Exception('Failed to delete supplier');
    }
  }
}
