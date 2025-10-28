class TipoCse {
  final int id;
  final String nome;

  TipoCse({
    required this.id,
    required this.nome,
  });

  factory TipoCse.fromJson(Map<String, dynamic> json) {
    return TipoCse(
      id: json['id'],
      nome: json['nome'],
    );
  }
}