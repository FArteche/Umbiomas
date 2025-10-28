class Relevo {
  final int id;
  final String nome;
  final String? descricao;
  final String? tipo;
  final String? imagemUrl;

  Relevo({
    required this.id,
    required this.nome,
    this.descricao,
    this.tipo,
    this.imagemUrl,
  });

  factory Relevo.fromJson(Map<String, dynamic> json) {
    return Relevo(
      id: json['id'],
      nome: json['nome'],
      descricao: json['descricao'],
      tipo: json['tipo'],
      imagemUrl: json['imagem_url'],
    );
  }
}
