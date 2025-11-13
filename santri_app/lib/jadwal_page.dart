import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class JadwalPage extends StatefulWidget {
  const JadwalPage({super.key});

  @override
  State<JadwalPage> createState() => _JadwalPageState();
}

class _JadwalPageState extends State<JadwalPage> {
  List jadwal = [];
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    fetchJadwal();
  }

  Future<void> fetchJadwal() async {
    try {
      final response = await http.get(
        Uri.parse('http://10.0.2.2:8000/api/jadwal'),
      );
      if (response.statusCode == 200) {
        setState(() {
          jadwal = jsonDecode(response.body);
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
        title: Text("Jadwal Kegiatan"),
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
            : jadwal.isEmpty
                ? Center(
                    child: Text(
                      "Belum ada jadwal.",
                      style: TextStyle(color: Colors.white70),
                    ),
                  )
                : ListView.builder(
                    padding: const EdgeInsets.all(16),
                    itemCount: jadwal.length,
                    itemBuilder: (context, index) {
                      final item = jadwal[index];
                      return Card(
                        color: const Color(0xFF232A34),
                        elevation: 6,
                        margin: EdgeInsets.only(bottom: 16),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(16),
                        ),
                        child: ListTile(
                          leading: CircleAvatar(
                            backgroundColor:
                                Color(0xFF2980B9).withOpacity(0.25),
                            radius: 28,
                            child: Icon(Icons.event_note,
                                color: Color(0xFF74ebd5), size: 32),
                          ),
                          title: Text(
                            item['kegiatan'],
                            style: TextStyle(
                              fontWeight: FontWeight.bold,
                              fontSize: 18,
                              color: Colors.white,
                            ),
                          ),
                          subtitle: Padding(
                            padding: const EdgeInsets.only(top: 4.0),
                            child: Text(
                              "${item['hari'] != null && item['hari'].toString().isNotEmpty ? item['hari'] : '-'}, "
                              "Jam: ${item['waktu'] != null && item['waktu'].toString().isNotEmpty ? item['waktu'] : '-'}",
                              style: TextStyle(
                                fontSize: 15,
                                color: Colors.grey[300],
                              ),
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
