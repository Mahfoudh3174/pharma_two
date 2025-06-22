// Generated Categories for Flutter
// This file contains all categories from the database
// Copy this to your Flutter project

class Category {
  final int id;
  final String name;
  final String svgLogo;

  const Category({
    required this.id,
    required this.name,
    required this.svgLogo,
  });

  Map<String, dynamic> toMap() {
    return {
      'id': id,
      'name': name,
      'svg_logo': svgLogo,
    };
  }

  factory Category.fromMap(Map<String, dynamic> map) {
    return Category(
      id: map['id']?.toInt() ?? 0,
      name: map['name'] ?? '',
      svgLogo: map['svg_logo'] ?? '',
    );
  }
}

class CategoriesData {
  static const List<Category> categories = [
    Category(
      id: 1,
      name: 'Antibiotics',
      svgLogo: 'antibiotics.svg',
    ),
    Category(
      id: 2,
      name: 'Pain Relief',
      svgLogo: 'pain-relief.svg',
    ),
    Category(
      id: 3,
      name: 'Vitamins & Supplements',
      svgLogo: 'vitamins.svg',
    ),
    Category(
      id: 4,
      name: 'Cardiovascular',
      svgLogo: 'cardiovascular.svg',
    ),
    Category(
      id: 5,
      name: 'Diabetes',
      svgLogo: 'diabetes.svg',
    ),
    Category(
      id: 6,
      name: 'Respiratory',
      svgLogo: 'respiratory.svg',
    ),
    Category(
      id: 7,
      name: 'Digestive Health',
      svgLogo: 'digestive.svg',
    ),
    Category(
      id: 8,
      name: 'Mental Health',
      svgLogo: 'mental-health.svg',
    ),
    Category(
      id: 9,
      name: 'Women\'s Health',
      svgLogo: 'womens-health.svg',
    ),
    Category(
      id: 10,
      name: 'Men\'s Health',
      svgLogo: 'mens-health.svg',
    ),
    Category(
      id: 11,
      name: 'Children\'s Health',
      svgLogo: 'childrens-health.svg',
    ),
    Category(
      id: 12,
      name: 'Elderly Care',
      svgLogo: 'elderly-care.svg',
    ),
    Category(
      id: 13,
      name: 'First Aid',
      svgLogo: 'first-aid.svg',
    ),
    Category(
      id: 14,
      name: 'Dental Care',
      svgLogo: 'dental-care.svg',
    ),
    Category(
      id: 15,
      name: 'Eye Care',
      svgLogo: 'eye-care.svg',
    ),
    Category(
      id: 16,
      name: 'Skin Care',
      svgLogo: 'skin-care.svg',
    ),
    Category(
      id: 17,
      name: 'Hair Care',
      svgLogo: 'hair-care.svg',
    ),
    Category(
      id: 18,
      name: 'Baby Care',
      svgLogo: 'baby-care.svg',
    ),
    Category(
      id: 19,
      name: 'Medical Devices',
      svgLogo: 'medical-devices.svg',
    ),
    Category(
      id: 20,
      name: 'Health & Wellness',
      svgLogo: 'health-wellness.svg',
    ),
  ];

  static Category? getById(int id) {
    try {
      return categories.firstWhere((category) => category.id == id);
    } catch (e) {
      return null;
    }
  }

  static Category? getByName(String name) {
    try {
      return categories.firstWhere((category) => category.name.toLowerCase() == name.toLowerCase());
    } catch (e) {
      return null;
    }
  }

  static List<Category> search(String query) {
    return categories.where((category) => 
      category.name.toLowerCase().contains(query.toLowerCase())
    ).toList();
  }
}

// Usage examples:
// final allCategories = CategoriesData.categories;
// final category = CategoriesData.getById(1);
// final searchResults = CategoriesData.search('antibiotic');
// 
// In your Flutter widget:
// Image.asset('assets/svgs/' + category.svgLogo) 