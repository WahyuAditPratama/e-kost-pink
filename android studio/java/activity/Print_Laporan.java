package com.app.kostpink.activity;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.print.PrintAttributes;
import android.print.PrintDocumentAdapter;
import android.print.PrintManager;
import android.util.Log;
import android.view.View;
import android.webkit.WebView;
import android.webkit.WebViewClient;

import com.app.kostpink.Config;
import com.app.kostpink.R;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Locale;

public class Print_Laporan extends Activity {
	private WebView myWebView;
	String tgl1,tgl2;
String ip="";
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.print_transaksi);
		ip= Config.WEB_URL;
		//initialize webview
		myWebView = findViewById(R.id.myWebView);
		Intent i = getIntent();
		tgl1=i.getStringExtra("tgl1");
		tgl2=i.getStringExtra("tgl2");


		//add webview client to handle event of loading
		myWebView.setWebViewClient(new WebViewClient() {
			public boolean shouldOverrideUrlLoading(WebView view, String url) {
				return false;
			}

			@Override
			public void onPageFinished(WebView view, String url) {

				//if page loaded successfully then show print button
				findViewById(R.id.fab).setVisibility(View.VISIBLE);
			}
		});


		myWebView.getSettings().setJavaScriptEnabled(true);

		String cnvtgl1 = convertDateFormat(tgl1);
		String cnvtgl2 = convertDateFormat(tgl2);

		String url=ip+"laporan/cetak_laporan_tagihan?periode_awal="+cnvtgl1+"&periode_akhir="+cnvtgl2;
		myWebView.loadUrl(url);
		Log.d("URL",url);

		FloatingActionButton myFab = (FloatingActionButton) findViewById(R.id.fab);
		myFab.setOnClickListener(new View.OnClickListener() {
			public void onClick(View v) {
				printPDF();
			}
		});
	}

	//create a function to create the print job
	private void createWebPrintJob(WebView webView) {

		//create object of print manager in your device
		PrintManager printManager = (PrintManager) this.getSystemService(Context.PRINT_SERVICE);

		//create object of print adapter
		PrintDocumentAdapter printAdapter = webView.createPrintDocumentAdapter();

		//provide name to your newly generated pdf file
		String jobName = getString(R.string.app_name) + " Print Test";

		//open print dialog
		printManager.print(jobName, printAdapter, new PrintAttributes.Builder().build());
	}

	//perform click pdf creation operation on click of print button click
	public void printPDF() {
		createWebPrintJob(myWebView);
	}

    public String convertDateFormat(String inputDate) {
        SimpleDateFormat inputFormat = new SimpleDateFormat("d MMMM yyyy", new Locale("id", "ID"));
        SimpleDateFormat outputFormat = new SimpleDateFormat("yyyy-MM-dd");

        String outputDate = "";
        try {
            Date date = inputFormat.parse(inputDate);
            outputDate = outputFormat.format(date);
        } catch (ParseException e) {
            e.printStackTrace();
        }

        return outputDate;
    }
}
