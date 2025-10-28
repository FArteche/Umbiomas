class Bioma {
  final int id;
  final String nome;
  final String? imagemUrl;

  Bioma({required this.id, required this.nome, this.imagemUrl});

  factory Bioma.fromJson(Map<String, dynamic> json) {
    return Bioma(
      id: json['id'],
      nome: json['nome'],
      imagemUrl: json['imagem_url'],
    );
  }
}
