// lib/widgets/ranking_preview.dart
import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../models/ranking_entry.dart';

class RankingPreview extends StatefulWidget {
  final int biomaId;
  final Color themeColor; // Aceita a cor do tema

  const RankingPreview({
    Key? key,
    required this.biomaId,
    this.themeColor = Colors.purple, // Cor padrão
  }) : super(key: key);

  @override
  _RankingPreviewState createState() => _RankingPreviewState();
}

class _RankingPreviewState extends State<RankingPreview> {
  final ApiService apiService = ApiService();
  late Future<List<RankingEntry>> _rankingFuture;

  @override
  void initState() {
    super.initState();
    _rankingFuture = apiService.getRanking(widget.biomaId);
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: EdgeInsets.symmetric(horizontal: 12),
      decoration: BoxDecoration(
        color: Colors.deepPurple[100],
        border: Border.all(color: Colors.deepPurple[900]!),
        borderRadius: BorderRadius.circular(30),
      ),
      child: Padding(
        padding: const EdgeInsets.fromLTRB(16.0, 8.0, 16.0, 8.0),
        child: Column(
          children: [
            Text(
              'Ranking Semanal (Top 5)',
              style: Theme.of(
                context,
              ).textTheme.titleMedium?.copyWith(fontWeight: FontWeight.bold),
            ),
            SizedBox(height: 8),
            FutureBuilder<List<RankingEntry>>(
              future: _rankingFuture,
              builder: (context, snapshot) {
                if (snapshot.connectionState == ConnectionState.waiting) {
                  return Center(
                    child: Padding(
                      padding: const EdgeInsets.all(8.0),
                      child: CircularProgressIndicator(
                        strokeWidth: 2,
                        color: widget.themeColor,
                      ),
                    ),
                  );
                }

                if (snapshot.hasError) {
                  return Center(
                    child: Text(
                      'Erro ao carregar ranking',
                      style: TextStyle(color: Colors.red),
                    ),
                  );
                }

                if (!snapshot.hasData || snapshot.data!.isEmpty) {
                  return Padding(
                    padding: const EdgeInsets.all(8.0),
                    child: Text(
                      'Ninguém jogou esta semana. Seja o primeiro!',
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        fontStyle: FontStyle.italic,
                        color: Colors.grey[600],
                      ),
                    ),
                  );
                }

                List<RankingEntry> ranking = snapshot.data!;
                List<RankingEntry> top5 = ranking.take(5).toList();

                return Column(
                  children: top5.map((entry) {
                    return Padding(
                      padding: const EdgeInsets.symmetric(
                        vertical: 2.0,
                        horizontal: 8.0,
                      ),
                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Text(
                            '${entry.posicao}. ${entry.nome}',
                            style: TextStyle(fontSize: 15),
                          ),
                          Text(
                            '${entry.score} pts',
                            style: TextStyle(
                              fontSize: 15,
                              fontWeight: FontWeight.bold,
                              color: widget.themeColor, // Usa a cor do tema
                            ),
                          ),
                        ],
                      ),
                    );
                  }).toList(),
                );
              },
            ),
          ],
        ),
      ),
    );
  }
}
