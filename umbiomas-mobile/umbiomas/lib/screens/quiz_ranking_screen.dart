// lib/screens/quiz_ranking_screen.dart
import 'package:flutter/material.dart';
import 'package:umbiomas/models/ranking_entry.dart';
import 'package:umbiomas/services/api_service.dart';

class QuizRankingScreen extends StatefulWidget {
  final int biomaId;
  final String biomaNome;

  const QuizRankingScreen({
    Key? key,
    required this.biomaId,
    required this.biomaNome,
  }) : super(key: key);

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
    final Color quizPrimaryColor = Colors.purple[700]!;
    final Color quizGradientStart = Colors.purple[300]!.withOpacity(0.5);
    final Color quizGradientEnd = Colors.white;

    return Scaffold(
      appBar: AppBar(
        title: Text('Ranking - ${widget.biomaNome}'),
        backgroundColor: quizPrimaryColor, // Cor tema
      ),
      body: Container(
        // Aplicando o gradiente de fundo
        decoration: BoxDecoration(
          gradient: LinearGradient(
            colors: [quizGradientStart, quizGradientEnd],
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            stops: [0.0, 0.7],
          ),
        ),
        child: FutureBuilder<List<RankingEntry>>(
          future: _rankingFuture,
          builder: (context, snapshot) {
            if (snapshot.connectionState == ConnectionState.waiting) {
              return Center(
                child: CircularProgressIndicator(color: quizPrimaryColor),
              );
            } else if (snapshot.hasError) {
              return Center(
                child: Text('Erro ao carregar o ranking: ${snapshot.error}'),
              );
            } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
              return Center(/* ... (texto de lista vazia) ... */);
            } else {
              List<RankingEntry> ranking = snapshot.data!;
              return ListView.builder(
                padding: EdgeInsets.symmetric(vertical: 8.0),
                itemCount: ranking.length,
                itemBuilder: (context, index) {
                  final entry = ranking[index];
                  // Define a cor de destaque para o Top 3
                  final bool isTop3 = entry.posicao <= 3;
                  final Color leadingColor = isTop3
                      ? quizPrimaryColor
                      : Colors.grey[400]!;
                  final Color leadingTextColor = isTop3
                      ? Colors.white
                      : Colors.black54;

                  return Card(
                    margin: EdgeInsets.symmetric(horizontal: 10, vertical: 5),
                    elevation: isTop3 ? 3 : 1, // Destaque para o Top 3
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(10),
                      side: isTop3
                          ? BorderSide(color: quizPrimaryColor, width: 1.5)
                          : BorderSide.none,
                    ),
                    child: ListTile(
                      leading: CircleAvatar(
                        backgroundColor: leadingColor,
                        child: Text(
                          '${entry.posicao}',
                          style: TextStyle(
                            fontWeight: FontWeight.bold,
                            color: leadingTextColor,
                          ),
                        ),
                      ),
                      title: Text(
                        entry.nome,
                        style: TextStyle(fontWeight: FontWeight.w500),
                      ),
                      subtitle: Text('Em: ${entry.data}'),
                      trailing: Text(
                        '${entry.score} pts',
                        style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.bold,
                          color: quizPrimaryColor, // Cor tema
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
