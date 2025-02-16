using System.Runtime.InteropServices.JavaScript;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using SnackShop.Models;

namespace SnackShop.Pages;

public class Details : PageModel
{
    public Snack Snack { get; private set; }
    private readonly IHttpClientFactory _httpClientFactory;

    public Details(IHttpClientFactory clientFactory)
    {
        _httpClientFactory = clientFactory;
    }
    public async Task<IActionResult> OnGet(int? id)
    {
        if (id is null or 0)
        {
            return Page();
        }
        var client = _httpClientFactory.CreateClient();
        client.BaseAddress = new Uri("http://localhost:8000");
        var response = await client.GetAsync($"/Snacks.php?id={id}");
        if (!response.IsSuccessStatusCode)
        {
            return Page();
        }
        var content = await response.Content.ReadAsStringAsync();
        var data = System.Text.Json.JsonSerializer.Deserialize<IEnumerable<Snack>>(content);
        var snacks = data?.ToArray() ?? [];
        if (snacks.Length == 0)
        {
            return Page();
        }
        Snack = snacks.First();
        return Page();
    }
}