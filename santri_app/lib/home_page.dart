import 'package:flutter/material.dart';
import 'package:santri_app/absensi_page.dart';

class HomePage extends StatelessWidget {
  final Map santri;

  const HomePage({super.key, required this.santri});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFF181C24),
      appBar: AppBar(
        backgroundColor: const Color(0xFF232A34),
        title: Text(
          'Santri Nurussalam',
          style: TextStyle(fontWeight: FontWeight.bold, color: Colors.white),
        ),
        centerTitle: true,
        elevation: 8,
        shadowColor: Colors.black45,
        actions: [
          IconButton(
            icon: Icon(Icons.logout, color: Colors.red[200]),
            tooltip: 'Logout',
            onPressed: () {
              Navigator.pushNamedAndRemoveUntil(
                context,
                '/',
                (route) => false,
              );
            },
          ),
        ],
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Card(
              color: const Color(0xFF232A34),
              elevation: 10,
              shadowColor: Colors.black54,
              shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(16)),
              child: Padding(
                padding: const EdgeInsets.symmetric(
                    vertical: 16.0, horizontal: 8.0),
                child: Row(
                  children: [
                    CircleAvatar(
                      radius: 32,
                      backgroundColor: const Color(0xFF2980B9),
                      child: Icon(Icons.person, color: Colors.white, size: 36),
                    ),
                    SizedBox(width: 16),
                    Expanded(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(santri['nama'],
                              style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  fontSize: 20,
                                  color: Colors.white)),
                          SizedBox(height: 4),
                          Text('NIS: ${santri['nis']}',
                              style: TextStyle(color: Colors.grey[400])),
                          Text('Kelas: ${santri['kelas']}',
                              style: TextStyle(color: Colors.grey[400])),
                        ],
                      ),
                    ),
                  ],
                ),
              ),
            ),
            SizedBox(height: 30),
            ElevatedButton.icon(
              style: ElevatedButton.styleFrom(
                backgroundColor: const Color(0xFF2980B9),
                minimumSize: Size(double.infinity, 55),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(12),
                ),
                elevation: 4,
                shadowColor: Colors.blueGrey,
              ),
              onPressed: () {
                Navigator.pushNamed(context, '/pengumuman');
              },
              icon: Icon(Icons.campaign, size: 28, color: Colors.white),
              label: Text('Lihat Pengumuman',
                  style: TextStyle(fontSize: 18, color: Colors.white)),
            ),
            SizedBox(height: 16),
            ElevatedButton.icon(
              style: ElevatedButton.styleFrom(
                backgroundColor: const Color(0xFF6C3483),
                minimumSize: Size(double.infinity, 55),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(12),
                ),
                elevation: 4,
                shadowColor: Colors.deepPurple,
              ),
              onPressed: () {
                Navigator.pushNamed(context, '/jadwal');
              },
              icon: Icon(Icons.schedule, size: 28, color: Colors.white),
              label: Text('Lihat Jadwal',
                  style: TextStyle(fontSize: 18, color: Colors.white)),
            ),
            SizedBox(height: 16),
            ElevatedButton.icon(
              style: ElevatedButton.styleFrom(
                backgroundColor: const Color(0xFF27AE60),
                minimumSize: Size(double.infinity, 55),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(12),
                ),
                elevation: 4,
                shadowColor: Colors.green,
              ),
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(
                    builder: (context) => AbsensiPage(santriId: santri['id']),
                  ),
                );
              },
              icon: Icon(Icons.check_circle_outline, size: 28, color: Colors.white),
              label: Text('Lihat Absensi',
                  style: TextStyle(fontSize: 18, color: Colors.white)),
            ),
            Spacer(),
            Center(
              child: Text(
                "© 2025 Pondok Pesantren Nurussalam",
                style: TextStyle(color: Colors.grey[600], fontSize: 13),
              ),
            ),
          ],
        ),
      ),
    );
  }
}