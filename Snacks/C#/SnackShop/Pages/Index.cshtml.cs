using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using SnackShop.Models;

namespace SnackShop.Pages;

public class IndexModel : PageModel
{
    private readonly ILogger<IndexModel> _logger;
    private readonly IHttpClientFactory _httpClientFactory;
    public List<Snack> Snacks { get; private set; } = [];

    public IndexModel(ILogger<IndexModel> logger
    , IHttpClientFactory httpClientFactory)
    {
        _logger = logger;
        _httpClientFactory = httpClientFactory;
    }

    public async Task<IActionResult> OnGet()
    {
        var client = _httpClientFactory.CreateClient();
        client.BaseAddress = new Uri("http://localhost:8000");
        var response = await client.GetAsync("/Snacks.php");
        if (!response.IsSuccessStatusCode)
        {
            return Page();
        }
        var content = await response.Content.ReadAsStringAsync();
        IEnumerable<Snack> data = System.Text.Json.JsonSerializer.Deserialize<IEnumerable<Snack>>(content) ?? Array.Empty<Snack>();
        Snacks = data.ToList();
        return Page();
    }
}