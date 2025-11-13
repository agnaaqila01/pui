import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class PengumumanPage extends StatefulWidget {
  const PengumumanPage({super.key});

  @override
  State<PengumumanPage> createState() => _PengumumanPageState();
}

class _PengumumanPageState extends State<PengumumanPage> {
  List pengumuman = [];
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    fetchPengumuman();
  }

  Future<void> fetchPengumuman() async {
    try {
      final response = await http.get(
        Uri.parse('http://10.0.2.2:8000/api/pengumuman'),
      );

      if (response.statusCode == 200) {
        setState(() {
          pengumuman = jsonDecode(response.body);
          isLoading = false;
        });
      } else {
        throw Exception('Gagal mengambil data');
      }
    } catch (e) {
      setState(() {
        isLoading = false;
      });
      print('Error fetch: $e');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFF181C24),
      appBar: AppBar(
        title: Text("Pengumuman"),
        backgroundColor: const Color(0xFF232A34),
        elevation: 8,
        shadowColor: Colors.black45,
      ),
      body: Container(
        decoration: const BoxDecoration(
          gradient: LinearGradient(
            colors: [Color(0xFF232A34), Color(0xFF181C24)],
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
          ),
        ),
        child: isLoading
            ? Center(child: CircularProgressIndicator(color: Colors.white))
            : pengumuman.isEmpty
                ? Center(
                    child: Text(
                      "Belum ada pengumuman.",
                      style: TextStyle(color: Colors.white70),
                    ),
                  )
                : ListView.builder(
                    padding: const EdgeInsets.all(16),
                    itemCount: pengumuman.length,
                    itemBuilder: (context, index) {
                      final item = pengumuman[index];
                      return Card(
                        color: const Color(0xFF232A34),
                        elevation: 6,
                        margin: EdgeInsets.only(bottom: 16),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(16),
                        ),
                        child: ListTile(
                          leading: CircleAvatar(
                            backgroundColor: Color(0xFF2980B9).withOpacity(0.18),
                            radius: 28,
                            child: Icon(Icons.campaign, color: Color(0xFF74ebd5), size: 32),
                          ),
                          title: Text(
                            item['judul'],
                            style: TextStyle(
                              fontWeight: FontWeight.bold,
                              fontSize: 18,
                              color: Colors.white,
                            ),
                          ),
                          subtitle: Padding(
                            padding: const EdgeInsets.only(top: 4.0),
                            child: Text(
                              item['isi'],
                              style: TextStyle(fontSize: 15, color: Colors.grey[300]),
                            ),
                          ),
                        ),
                      );
                    },
                  ),
      ),
    );
  }
}