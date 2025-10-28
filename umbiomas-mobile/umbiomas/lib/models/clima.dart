class Clima {
  final int id;
  final String nome;
  final String? descricao;
  final String? imagemUrl;

  Clima({required this.id, required this.nome, this.descricao, this.imagemUrl});

  factory Clima.fromJson(Map<String, dynamic> json) {
    return Clima(
      id: json['id'],
      nome: json['nome'],
      descricao: json['descricao'],
      imagemUrl: json['imagem_url'],
    );
  }
}
