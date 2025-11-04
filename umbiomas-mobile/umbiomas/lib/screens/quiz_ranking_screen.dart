import 'package:flutter/material.dart';
import 'package:umbiomas/models/ranking_entry.dart';
import 'package:umbiomas/services/api_service.dart';

class QuizRankingScreen extends StatefulWidget {
  final int biomaId;
  final String biomaNome;

  const QuizRankingScreen({Key? key, required this.biomaId, required this.biomaNome}) : super(key: key);

  @override
  _QuizRankingScreenState createState() => _QuizRankingScreenState();
}

class _QuizRankingScreenState extends State<QuizRankingScreen> {
  final ApiService apiService = ApiService();
  late Future<List<RankingEntry>> _rankingFuture;

  @override
  void initState() {
    super.initState();
    _rankingFuture = apiService.getRanking(widget.biomaId);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Ranking - ${widget.biomaNome}'),
      ),
      body: FutureBuilder<List<RankingEntry>>(
        future: _rankingFuture,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return Center(child: CircularProgressIndicator());
          } else if (snapshot.hasError) {
            return Center(child: Text('Erro ao carregar o ranking: ${snapshot.error}'));
          } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
            return Center(
              child: Text(
                'Nenhuma pontuação registrada esta semana.\nSeja o primeiro!',
                textAlign: TextAlign.center,
                style: TextStyle(fontSize: 16, fontStyle: FontStyle.italic, color: Colors.grey[600]),
              ),
            );
          } else {
            List<RankingEntry> ranking = snapshot.data!;
            return ListView.builder(
              itemCount: ranking.length,
              itemBuilder: (context, index) {
                final entry = ranking[index];
                return ListTile(
                  // Ícone de Posição
                  leading: CircleAvatar(
                    backgroundColor: entry.posicao <= 3 
                        ? Theme.of(context).colorScheme.primary 
                        : Colors.grey[300],
                    child: Text(
                      '${entry.posicao}',
                      style: TextStyle(
                        fontWeight: FontWeight.bold,
                        color: entry.posicao <= 3 ? Colors.white : Colors.black54,
                      ),
                    ),
                  ),
                  // Nome e Data
                  title: Text(entry.nome, style: TextStyle(fontWeight: FontWeight.w500)),
                  subtitle: Text('Em: ${entry.data}'),
                  // Pontuação
                  trailing: Text(
                    '${entry.score} pts',
                    style: TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.bold,
                      color: Theme.of(context).colorScheme.primary,
                    ),
                  ),
                );
              },
            );
          }
        },
      ),
    );
  }
}