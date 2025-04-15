function scrollToTrending() {
  const trendingSection = document.getElementById("trending-products");
  if (trendingSection) {
    trendingSection.scrollIntoView({ behavior: "smooth" });
  }
}
