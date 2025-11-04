import 'package:flutter/material.dart';

class StyledContentBox extends StatelessWidget {
  final Widget child;
  final EdgeInsetsGeometry? padding;

  const StyledContentBox({Key? key, required this.child, this.padding})
    : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: padding ?? const EdgeInsets.all(7.0),
      width: double.infinity,
      decoration: BoxDecoration(
        color: Colors.green[50], 
        borderRadius: BorderRadius.circular(7.0),
        border: Border.all(color: Colors.green[200]!), 
      ),
      child: child,
    );
  }
}
