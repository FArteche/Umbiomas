import 'package:flutter/material.dart';
import 'package:umbiomas/models/bioma.dart';
import 'package:umbiomas/navigation/fade_page_route.dart';
import 'package:umbiomas/screens/biomas_detail_screen.dart';
import 'package:umbiomas/services/api_service.dart';

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
      appBar: AppBar(title: Text('Biomas'), backgroundColor: Color.fromRGBO(46, 125, 50, 1)),
      body: Container(
        decoration: BoxDecoration(
          gradient: LinearGradient(
            colors:  [Color.fromRGBO(46, 125, 50, 1), Colors.lightGreen[50]!],
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            stops: [0.0, 0.7],
          ),
        ),
        child: FutureBuilder<List<Bioma>>(
          future: _biomasFuture,
          builder: (context, snapshot) {
            if (snapshot.connectionState == ConnectionState.waiting) {
              return Center(child: CircularProgressIndicator());
            } else if (snapshot.hasError) {
              return Center(
                child: Padding(
                  padding: const EdgeInsets.all(16.0),
                  child: Text(
                    'Erro ao carregar biomas: ${snapshot.error}\n\nVerifique sua conexão.',
                    textAlign: TextAlign.center,
                  ),
                ),
              );
            } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
              return Center(child: Text('Nenhum Biomas Encontrado.'));
            } else {
              List<Bioma> biomas = snapshot.data!;
              return ListView.builder(
                itemCount: biomas.length,
                itemBuilder: (context, index) {
                  final bioma = biomas[index];
                  return Card(
                    clipBehavior: Clip.antiAlias,
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
                        height: 100,
                        decoration: BoxDecoration(
                          image: DecorationImage(
                            image: bioma.imagemUrl != null
                                ? NetworkImage(bioma.imagemUrl!)
                                : AssetImage('assets/images/placeholder.png')
                                      as ImageProvider,
                            fit: BoxFit.cover,
                            colorFilter: ColorFilter.mode(
                              Colors.black.withOpacity(0.4),
                              BlendMode.darken,
                            ),
                          ),
                        ),
                        // Conteúdo que fica SOBRE a imagem de fundo
                        child: Align(
                          // Alinha o texto no centro-esquerda (ou onde preferir)
                          alignment: Alignment.centerLeft,
                          child: Padding(
                            padding: const EdgeInsets.symmetric(
                              horizontal: 16.0,
                            ),
                            child: Text(
                              bioma.nome,
                              style: TextStyle(
                                color: Colors.white, // Cor do texto
                                fontSize: 20, // Tamanho do texto
                                fontWeight: FontWeight.bold, // Peso da fonte
                                shadows: [
                                  Shadow(
                                    blurRadius: 10.0,
                                    color: Colors.black.withOpacity(0.5),
                                    offset: Offset(2.0, 2.0),
                                  ),
                                ],
                              ),
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
