class TipoAreaPreservacao {
  final int id;
  final String nome;

  TipoAreaPreservacao({
    required this.id,
    required this.nome,
  });

  factory TipoAreaPreservacao.fromJson(Map<String, dynamic> json) {
    return TipoAreaPreservacao(
      id: json['id'],
      nome: json['nome'],
    );
  }
}