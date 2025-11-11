// lib/screens/biomas_screen.dart
import 'package:flutter/material.dart';
import 'package:umbiomas/models/bioma.dart';
import 'package:umbiomas/navigation/fade_page_route.dart';
import 'package:umbiomas/screens/biomas_detail_screen.dart';
import 'package:umbiomas/services/api_service.dart';
import 'package:umbiomas/theme/app_theme.dart'; // Importe o tema

class BiomasScreen extends StatefulWidget {
  const BiomasScreen({super.key});

  @override
  State<BiomasScreen> createState() => _BiomasScreenState();
}

class _BiomasScreenState extends State<BiomasScreen> {
  final ApiService apiService = ApiService();
  late Future<List<Bioma>> _biomasFuture;

  @override
  void initState() {
    super.initState();
    _biomasFuture = apiService.fetchBiomas();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Biomas')),
      body: Container(
        decoration: BoxDecoration(gradient: AppTheme.backgroundGradient), 
        child: FutureBuilder<List<Bioma>>(
          future: _biomasFuture,
          builder: (context, snapshot) {
            if (snapshot.connectionState == ConnectionState.waiting) {
              return Center(child: CircularProgressIndicator());
            } else if (snapshot.hasError) {
              return Center(/* ... (erro) ... */);
            } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
              return Center(child: Text('Nenhum Bioma Encontrado.'));
            } else {
              List<Bioma> biomas = snapshot.data!;
              return ListView.builder(
                padding: EdgeInsets.all(10.0), 
                itemCount: biomas.length,
                itemBuilder: (context, index) {
                  final bioma = biomas[index];
                  return Card(
                    clipBehavior: Clip.antiAlias,
                    elevation: 3.0, 
                    child: InkWell(
                      onTap: () {
                        Navigator.push(
                          context,
                          FadePageRoute(
                            child: BiomaDetailScreen(biomaId: bioma.id),
                          ),
                        );
                      },
                      child: Container(
                        height: 120, 
                        decoration: BoxDecoration(
                          image: DecorationImage(
                            image: bioma.imagemUrl != null
                                ? NetworkImage(bioma.imagemUrl!)
                                : AssetImage('assets/images/logo_tr.png')
                                      as ImageProvider,
                            fit: BoxFit.cover,
                            colorFilter: ColorFilter.mode(
                              Colors.black.withOpacity(0.45), // Escurece um pouco mais
                              BlendMode.darken,
                            ),
                          ),
                        ),
                        child: Align(
                          alignment: Alignment.center, // Centraliza o texto
                          child: Text(
                            bioma.nome,
                            style: TextStyle(
                              color: Colors.white,
                              fontSize: 22, // Tamanho do texto
                              fontWeight: FontWeight.bold,
                              shadows: [
                                Shadow(
                                  blurRadius: 10.0,
                                  color: Colors.black.withOpacity(0.7),
                                  offset: Offset(2.0, 2.0),
                                ),
                              ],
                            ),
                          ),
                        ),
                      ),
                    ),
                  );
                },
              );
            }
          },
        ),
      ),
    );
  }
}