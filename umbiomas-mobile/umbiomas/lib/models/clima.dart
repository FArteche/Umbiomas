class Clima {
  final int id;
  final String nome;
  final String? descricao;
  final String? imagemUrl;
  final List<String>? tambemPresenteEm;

  Clima({
    required this.id,
    required this.nome,
    this.descricao,
    this.imagemUrl,
    this.tambemPresenteEm,
  });

  factory Clima.fromJson(Map<String, dynamic> json) {
    List<String>? outrosBiomas;
    if (json['tambem_presente_em'] != null &&
        json['tambem_presente_em'] is List) {
      outrosBiomas = List<String>.from(json['tambem_presente_em']);
    }
    return Clima(
      id: json['id'] as int? ?? 0,
      nome: json['nome'] as String? ?? 'Nome indisponível',
      descricao: json['descricao'] as String?,
      imagemUrl: json['imagem_url'] as String?,
      tambemPresenteEm: outrosBiomas,
    );
  }
}
