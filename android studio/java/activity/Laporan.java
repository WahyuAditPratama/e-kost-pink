package com.app.kostpink.activity;

import android.app.Activity;
import android.app.DatePickerDialog;
import android.content.Intent;
import android.os.Bundle;
import android.view.KeyEvent;
import android.view.View;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;

import androidx.appcompat.app.AppCompatActivity;

import com.app.kostpink.R;

import java.util.Calendar;


public class Laporan extends AppCompatActivity {

    DatePickerDialog picker;
    EditText txttgl1, txttgl2;

    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.adm_activity_laporan_keuangan);


        getSupportActionBar().setTitle("Detail Booking");
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        txttgl1 = (EditText) findViewById(R.id.txttgl1);
        txttgl1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final Calendar cldr = Calendar.getInstance();
                int day = cldr.get(Calendar.DAY_OF_MONTH);
                int month = cldr.get(Calendar.MONTH);
                int year = cldr.get(Calendar.YEAR);
                picker = new DatePickerDialog(Laporan.this, new DatePickerDialog.OnDateSetListener() {
                    @Override
                    public void onDateSet(DatePicker view, int year, int monthOfYear, int dayOfMonth) {
                        String BUL = "Januari";
                        int b = (monthOfYear + 1);
                        if (b == 1) {
                            BUL = "Januari";
                        } else if (b == 2) {
                            BUL = "Februari";
                        } else if (b == 3) {
                            BUL = "Maret";
                        } else if (b == 4) {
                            BUL = "Aprril";
                        } else if (b == 5) {
                            BUL = "Mei";
                        } else if (b == 6) {
                            BUL = "Juni";
                        } else if (b == 7) {
                            BUL = "Juli";
                        } else if (b == 8) {
                            BUL = "Agustus";
                        } else if (b == 9) {
                            BUL = "September";
                        } else if (b == 10) {
                            BUL = "Oktober";
                        } else if (b == 11) {
                            BUL = "November";
                        } else if (b == 12) {
                            BUL = "Desember";
                        }
                        txttgl1.setText(dayOfMonth + " " + BUL + " " + year);
                    }
                }, year, month, day);
                picker.show();
            }
        });

        txttgl2 = (EditText) findViewById(R.id.txttgl2);
        txttgl2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final Calendar cldr = Calendar.getInstance();
                int day = cldr.get(Calendar.DAY_OF_MONTH);
                int month = cldr.get(Calendar.MONTH);
                int year = cldr.get(Calendar.YEAR);
                picker = new DatePickerDialog(Laporan.this, new DatePickerDialog.OnDateSetListener() {
                    @Override
                    public void onDateSet(DatePicker view, int year, int monthOfYear, int dayOfMonth) {
                        String BUL = "Januari";
                        int b = (monthOfYear + 1);
                        if (b == 1) {
                            BUL = "Januari";
                        } else if (b == 2) {
                            BUL = "Februari";
                        } else if (b == 3) {
                            BUL = "Maret";
                        } else if (b == 4) {
                            BUL = "Aprril";
                        } else if (b == 5) {
                            BUL = "Mei";
                        } else if (b == 6) {
                            BUL = "Juni";
                        } else if (b == 7) {
                            BUL = "Juli";
                        } else if (b == 8) {
                            BUL = "Agustus";
                        } else if (b == 9) {
                            BUL = "September";
                        } else if (b == 10) {
                            BUL = "Oktober";
                        } else if (b == 11) {
                            BUL = "November";
                        } else if (b == 12) {
                            BUL = "Desember";
                        }
                        txttgl2.setText(dayOfMonth + " " + BUL + " " + year);
                    }
                }, year, month, day);
                picker.show();
            }
        });

        Button btnProses = (Button) findViewById(R.id.btnproses);
        btnProses.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String tgl1 = txttgl1.getText().toString();
                String tgl2 = txttgl2.getText().toString();
                Intent i = new Intent(Laporan.this, Print_Laporan.class);
                i.putExtra("tgl1", tgl1);
                i.putExtra("tgl2", tgl2);
                startActivity(i);

            }


        });
        Button btnbatal = (Button) findViewById(R.id.btnbatal);
        btnbatal.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String tgl1 = txttgl1.getText().toString();
                String tgl2 = txttgl2.getText().toString();
            }

        });
    }


    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            finish();
            return true;
        }
        return super.onKeyDown(keyCode, event);
    }

}
