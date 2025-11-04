class Hidrografia {
  final int id;
  final String nome;
  final String? descricao;
  final String? tipo;
  final String? imagemUrl;

  Hidrografia({
    required this.id,
    required this.nome,
    this.descricao,
    this.tipo,
    this.imagemUrl,
  });

  factory Hidrografia.fromJson(Map<String, dynamic> json) {
    return Hidrografia(
      id: json['id'] as int? ?? 0,
      nome: json['nome'] as String? ?? 'Nome indisponível',
      descricao: json['descricao'] as String?,
      tipo: json['tipo'] as String?,
      imagemUrl: json['imagem_url'] as String?,
    );
  }
}
