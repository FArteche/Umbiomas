// lib/models/ranking_entry.dart
class RankingEntry {
  final int posicao;
  final String nome;
  final int score;
  final String data;

  RankingEntry({
    required this.posicao,
    required this.nome,
    required this.score,
    required this.data,
  });

  factory RankingEntry.fromJson(Map<String, dynamic> json) {
    return RankingEntry(
      posicao: json['posicao'] as int? ?? 0,
      nome: json['nome'] as String? ?? 'Anônimo',
      score: json['score'] as int? ?? 0,
      data: json['data'] as String? ?? '',
    );
  }
}