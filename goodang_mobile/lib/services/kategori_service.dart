import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import '../models/kategori.dart';
import 'auth_service.dart';

class KategoriService {
  static const String baseUrl = AuthService.baseUrl;

  static Future<List<Kategori>> getAllKategori(bool isAdmin) async {
    final endpoint = isAdmin ? '$baseUrl/kategori' : '$baseUrl/staffkategori';
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString('token');
    final response = await http.get(Uri.parse(endpoint), headers: {
      'Authorization': 'Bearer $token',
    });
    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      List<dynamic> list = data['data'];
      return list.map((json) => Kategori.fromJson(json)).toList();
    } else {
      throw Exception('Failed to load kategori');
    }
  }

  static Future<Kategori> getKategori(int id, bool isAdmin) async {
    final endpoint = isAdmin ? '$baseUrl/kategori/$id' : '$baseUrl/staffkategori/$id';
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString('token');
    final response = await http.get(Uri.parse(endpoint), headers: {
      'Authorization': 'Bearer $token',
    });
    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      return Kategori.fromJson(data['data']);
    } else {
      throw Exception('Failed to load kategori');
    }
  }

  static Future<Kategori> createKategori(String nama) async {
    final endpoint = '$baseUrl/kategori';
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString('token');
    final response = await http.post(Uri.parse(endpoint), headers: {
      'Authorization': 'Bearer $token',
    }, body: {
      'nama': nama,
    });
    if (response.statusCode == 201) {
      final data = jsonDecode(response.body);
      return Kategori.fromJson(data['data']);
    } else {
      throw Exception('Failed to create kategori');
    }
  }

  static Future<Kategori> updateKategori(int id, String nama) async {
    final endpoint = '$baseUrl/kategori/$id';
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString('token');
    final response = await http.put(Uri.parse(endpoint), headers: {
      'Authorization': 'Bearer $token',
    }, body: {
      'nama': nama,
    });
    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      return Kategori.fromJson(data['data']);
    } else {
      throw Exception('Failed to update kategori');
    }
  }

  static Future<void> deleteKategori(int id) async {
    final endpoint = '$baseUrl/kategori/$id';
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString('token');
    final response = await http.delete(Uri.parse(endpoint), headers: {
      'Authorization': 'Bearer $token',
    });
    if (response.statusCode != 200) {
      throw Exception('Failed to delete kategori');
    }
  }
}
