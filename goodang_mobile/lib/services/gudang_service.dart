import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import '../models/gudang.dart';
import 'auth_service.dart';

class GudangService {
  static const String baseUrl = AuthService.baseUrl;

  // Get all Gudang (admin uses /gudang; non-admin uses /staffgudang)
  static Future<List<Gudang>> getAllGudang(bool isAdmin) async {
    final endpoint = isAdmin ? '$baseUrl/gudang' : '$baseUrl/staffgudang';
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString('token');
    final response = await http.get(Uri.parse(endpoint), headers: {
      'Authorization': 'Bearer $token',
    });
    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      List<dynamic> list = data['data'];
      return list.map((json) => Gudang.fromJson(json)).toList();
    } else {
      throw Exception('Failed to load gudang');
    }
  }

  // Get a single Gudang
  static Future<Gudang> getGudang(int id, bool isAdmin) async {
    final endpoint =
        isAdmin ? '$baseUrl/gudang/$id' : '$baseUrl/staffgudang/$id';
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString('token');
    final response = await http.get(Uri.parse(endpoint), headers: {
      'Authorization': 'Bearer $token',
    });
    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      return Gudang.fromJson(data['data']);
    } else {
      throw Exception('Failed to load gudang');
    }
  }

  // Create Gudang (admin only)
  static Future<Gudang> createGudang(String nama, String alamat) async {
    final endpoint = '$baseUrl/gudang';
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString('token');
    final response = await http.post(Uri.parse(endpoint), headers: {
      'Authorization': 'Bearer $token',
    }, body: {
      'nama': nama,
      'alamat': alamat,
    });
    if (response.statusCode == 201) {
      final data = jsonDecode(response.body);
      return Gudang.fromJson(data['data']);
    } else {
      throw Exception('Failed to create gudang');
    }
  }

  // Update Gudang (admin only)
  static Future<Gudang> updateGudang(int id, String nama, String alamat) async {
    final endpoint = '$baseUrl/gudang/$id';
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString('token');
    final response = await http.put(Uri.parse(endpoint), headers: {
      'Authorization': 'Bearer $token',
    }, body: {
      'nama': nama,
      'alamat': alamat,
    });
    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      return Gudang.fromJson(data['data']);
    } else {
      throw Exception('Failed to update gudang');
    }
  }

  // Delete Gudang (admin only)
  static Future<void> deleteGudang(int id) async {
    final endpoint = '$baseUrl/gudang/$id';
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString('token');
    final response = await http.delete(Uri.parse(endpoint), headers: {
      'Authorization': 'Bearer $token',
    });
    if (response.statusCode != 200) {
      throw Exception('Failed to delete gudang');
    }
  }
}
